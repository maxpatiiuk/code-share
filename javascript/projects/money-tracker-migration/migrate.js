const fs = require('fs');

// Rocket money export converted to JSON using https://csvjson.com/
const data = JSON.parse(fs.readFileSync('rocket-money.json', 'utf8'));
const keys = new Set(data.flatMap((row) => Object.keys(row)));

// Map Rocket Money account names to Copilot account names
const accountMapper = {
  /* redacted */
};

// Copilot data after migration to check if data was imported correctly
const copilotData = JSON.parse(fs.readFileSync('copilot-after.json', 'utf8'))
  .map((row) => ({
    // Convert Copilot Data back to Rocket Money format to make diffing easier
    Date: row['date'],
    'Account Name': accountMapper[row['account']],
    Amount: row['amount'],
    Category:
      row['category'] === 'Other' && row['type'] === 'internal transfer'
        ? 'Internal Transfers'
        : row['category'] ||
          (row['type'] === 'income' ? 'Income' : '') ||
          (row['type'] === 'internal transfer' ? 'Internal Transfers' : ''),
    Name: row['name'],
    Note: row['note'],
  }))
  .filter((row) => row['Account Name'] !== undefined);

const steps = {
  printSummary() {
    keys.forEach((key) => {
      const object = {};
      data.forEach((row) => {
        object[row[key]] ??= 0;
        object[row[key]] += 1;
      });
      const entries = Object.entries(object);
      console.log(
        key,
        entries.length,
        entries.length > 30
          ? ''
          : entries
              .sort(
                ([_, leftValue], [__, rightValue]) => rightValue - leftValue
              )
              .map(([key, value]) => `${key} (${value})`)
              .join(', ')
      );
    });
  },

  // Print unique values for a pair of these keys
  echoPairs() {
    [
      ['Account Type', 'Account Name', 'Account Number', 'Institution Name'],
    ].forEach((pairs) => {
      const unique = new Set();
      data.forEach((row) =>
        unique.add(pairs.map((key) => row[key]).join('$$1'))
      );
      console.log(pairs);
      Array.from(unique).forEach((pair) => {
        console.log(pair.split('$$1').join(', '));
      });
    });
  },

  excludeColumns() {
    const newData = data.map((row) => {
      row['Account Type'] = undefined;
      row['Account Number'] = undefined;
      row['Institution Name'] = undefined;
      row['Tax Deductible'] = undefined;
      row['Custom Name'] = undefined;
      row['Original Date'] = undefined;
      row['Ignored From'] = undefined;
      row['Description'] = undefined;
      return row;
    });
    steps.write(newData);
  },

  write(newData) {
    fs.writeFileSync('rocket-money.json', JSON.stringify(newData, null, 2));
  },

  listCustomNames() {
    data
      .filter(
        (row) => row['Custom Name'] !== '' && row['Custom Name'] !== row['Name']
      )
      .forEach((row) => console.log(row['Name'], '=>', row['Custom Name']));
  },

  showOriginalDateDiffs() {
    data
      .filter(
        (row) =>
          row['Original Date'] !== '' && row['Original Date'] !== row['Date']
      )
      .forEach((row) => console.log(row['Original Date'], '=>', row['Date']));
  },

  deleteNeedlessDescriptions() {
    const newData = data.map((row) => {
      if (
        row['Description'] === row['Name'] ||
        row['Description'] === row['Note']
      )
        row['Description'] = undefined;
      return row;
    });
    steps.write(newData);
  },

  normalize() {
    const newData = data.map((row) => {
      return {
        Date: row['Date'],
        'Account Name': row['Account Name'],
        Amount: row['Amount'],
        Category: row['Category'],
        Name: row['Name'],
        Description: row['Description'] ?? '',
        Note: row['Note'],
      };
    });
    steps.write(newData);
  },

  removeDescriptions() {
    const newData = data.map((row) => {
      if (['Amazon', 'Audible'].some((name) => row['Name'].includes(name)))
        row['Description'] = '';
      return row;
    });
    steps.write(newData);
  },

  listUniqueNames() {
    const names = Array.from(new Set(data.map((row) => row['Name']))).sort();
    console.log(names.join('\n'));
  },

  listUniqueNotes() {
    const names = Array.from(new Set(data.map((row) => row['Note']))).sort();
    console.log(names.join('\n'));
  },

  outlierItems() {
    data.forEach((row) => {
      const category = row['Category'];
      if (categoryMapping[category] === 'Internal Transfers') return;
      const isIncome = category in incomeCategories;
      const isExpense = category in categoryMapping;
      if (isIncome && row['Amount'] > 0) console.log(row);
      else if (isExpense && row['Amount'] < 0) console.log(row);
      if (!isIncome && !isExpense)
        throw new Error(`Unknown category: ${category}`);
    });
  },

  updateCategoryNames() {
    const newData = data.map((row) => {
      const category = row['Category'];
      if (category in categoryMapping)
        row['Category'] = categoryMapping[category];
      else if (category in incomeCategories) {
        if (category !== 'Income') {
          row['Note'] = `${
            row['Note'] ?? ''
          }\n\nOriginal income category: ${category}`.trim();
        }
      } else throw new Error(`Unknown category: ${category}`);

      return row;
    });
    steps.write(newData);
  },

  toMintFormat() {
    const newData = data.map((row) => {
      const [year, month, day] = row['Date'].split('-');
      return {
        Date: `${month.replace(/^0/, '')}/${day}/${year}`,
        Description: row['Name'],
        'Original Description': row['Name'],
        Amount: Math.abs(row['Amount']),
        'Transaction Type': row['Amount'] < 0 ? 'credit' : 'debit',
        Category: row['Category'],
        'Account Name': row['Account Name'],
        Labels: '',
        Notes: row['Note'],
      };
    });
    fs.writeFileSync('mint-like.json', JSON.stringify(newData, null, 2));
  },

  groupData() {
    // Month -> Account -> Category -> Left/Right
    const group = (data, name, initial = {}) =>
      data.reduce((acc, row) => {
        const [year, month] = row['Date'].split('-');
        const date = `${year}-${month}`;
        acc[date] ??= {};
        acc[date][row['Account Name']] ??= {};
        acc[date][row['Account Name']][row['Category']] ??= {
          rocket: [],
          copilot: [],
        };
        acc[date][row['Account Name']][row['Category']][name].push(row);
        return acc;
      }, initial);
    // fs.writeFileSync('grouped.json', JSON.stringify(grouped, null, 2));
    // console.log(Array.from(new Set(data.map((row) => row['Account Name']))));
    // console.log(Array.from(new Set(copilotData.map((row) => row['Account Name']))));
    return group(copilotData, 'copilot', group(data, 'rocket'));
  },

  diffData() {
    const diffed = Object.fromEntries(
      Object.entries(steps.groupData())
        .map(([month, accounts]) => [
          month,
          Object.fromEntries(
            Object.entries(accounts)
              .map(([account, categories]) => [
                account,
                Object.fromEntries(
                  steps
                    .captureCategoryMismatches(
                      Object.entries(categories).map(
                        ([category, { rocket, copilot }]) => [
                          category,
                          steps.diff(rocket, copilot),
                        ]
                      )
                    )
                    .filter(
                      ([_, { copilot, rocket }]) =>
                        copilot.length > 0 || rocket.length > 0
                    )
                ),
              ])
              .filter(([_, categories]) => Object.keys(categories).length > 0)
          ),
        ])
        .filter(([_, accounts]) => Object.keys(accounts).length > 0)
    );

    if (steps.notesMismatch.length > 0) {
      fs.writeFileSync(
        'notesMismatch.json',
        JSON.stringify(steps.notesMismatch, null, 2)
      );
      console.log('Notes Mismatch:', steps.notesMismatch.length);
    }

    if (steps.categoryMismatch.length > 0) {
      fs.writeFileSync(
        'categoryMismatch.json',
        JSON.stringify(steps.categoryMismatch, null, 2)
      );
      console.log('Category Mismatch:', steps.categoryMismatch.length);
    }

    const stats = Object.values(diffed)
      .flat()
      .flatMap((account) => Object.values(account))
      .flatMap((category) => Object.values(category));
    const countUnmatchedRocket = stats.reduce(
      (acc, { rocket }) => acc + rocket.length,
      0
    );
    const countUnmatchedCopilot = stats.reduce(
      (acc, { copilot }) => acc + copilot.length,
      0
    );
    console.log('Unmatched Rocket:', countUnmatchedRocket);
    console.log('Unmatched Copilot:', countUnmatchedCopilot);

    fs.writeFileSync('diffed.json', JSON.stringify(diffed, null, 2));
  },

  notesMismatch: [],
  categoryMismatch: [],

  diff(rocket, copilotRaw) {
    const copilot = new Set(copilotRaw);
    const newRocket = rocket.filter((rocket) => {
      const copilotMatch = Array.from(copilot).find(
        (copilot) =>
          copilot['Amount'] === rocket['Amount'] &&
          copilot['Date'] === rocket['Date']
      );
      if (copilotMatch) {
        copilot.delete(copilotMatch);
        // if (copilotMatch['Note'] !== rocket['Note'])
        // steps.differing.push({ rocket, copilot: copilotMatch });
        return false;
      }
      return true;
    });
    return { rocket: newRocket, copilot: Array.from(copilot) };
  },

  captureCategoryMismatches(accountMonthEntries) {
    const rockets = accountMonthEntries.map(([_, { rocket }]) => rocket);
    const copilots = accountMonthEntries.map(([_, { copilot }]) => copilot);

    rockets.forEach((rockets) => {
      const matchedRockets = [];
      rockets.forEach((rocket) => {
        copilots.find((copilots) => {
          const copilotMatch = copilots.find(
            (copilot) =>
              copilot['Amount'] === rocket['Amount'] &&
              copilot['Date'] === rocket['Date']
          );
          if (copilotMatch) {
            copilots.splice(copilots.indexOf(copilotMatch), 1);
            matchedRockets.push(rocket);
            steps.categoryMismatch.push({ rocket, copilot: copilotMatch });
            return true;
          }
          return false;
        });
      });
      matchedRockets.forEach((rocket) =>
        rockets.splice(rockets.indexOf(rocket), 1)
      );
    });

    return accountMonthEntries;
  },

  boaToMint() {
    const boaData = JSON.parse(fs.readFileSync('boa.json', 'utf8'));
    const boaMapping = JSON.parse(fs.readFileSync('boa-mapping.json', 'utf8'));

    const newData = boaData.map(([date, fullName, _, amount]) => {
      const [name, ...parts] = fullName.trim().split(':');
      const description = parts.join(':').trim();
      const category = boaMapping[fullName];
      if (category === undefined)
        throw new Error(`Unknown category for ${name}`);
      const [year, month, day] = date.split('-');
      return {
        Date: `${month.replace(/^0/, '')}/${day}/${year}`,
        Description: name.trim(),
        'Original Description': name.trim(),
        Amount: Math.abs(amount),
        'Transaction Type': amount > 0 ? 'credit' : 'debit',
        Category: category,
        'Account Name': 'BoA Debit',
        Labels: '',
        Notes: description,
      };
    });
    fs.writeFileSync('boa-mint-like.json', JSON.stringify(newData, null, 2));
  },

  kuChargesToMint() {
    const data = JSON.parse(fs.readFileSync('ku-charges.json', 'utf8'));

    const newData = data.map(
      ({ Date, Amount, Category, Name, 'Semester + Year': Semester }) => {
        const [month, day, year] = Date.split('/');
        const name = 'The University of Kansas';
        const description = `${Semester}: ${Name}`;
        return {
          Date: `${month}/${day.padStart(2, '0')}/${year}`,
          Description: name,
          'Original Description': name,
          Amount,
          'Transaction Type': 'debit',
          Category,
          'Account Name': 'The University of Kansas',
          Labels: '',
          Notes: description,
        };
      }
    );
    fs.writeFileSync(
      'ku-charges-mint-like.json',
      JSON.stringify(newData, null, 2)
    );
  },

  kuPaymentsToMint() {
    const data = JSON.parse(fs.readFileSync('ku-payments.json', 'utf8'));

    const newData = data.map(
      ({ Date, Amount, Source, Internal, Name, Semester }) => {
        const [month, day, year] = Date.split('/');
        const name = 'The University of Kansas';
        const description = `${Semester}${Name.length > 0 ? `: ${Name}` : ''}`;
        return {
          Date: `${month.replace(/^0/, '')}/${day}/${year}`,
          Description: name,
          'Original Description': name,
          Amount: Math.abs(Amount),
          'Transaction Type': Amount > 0 ? 'credit' : 'debit',
          Category: Internal === 'TRUE' ? 'Internal Transactions' : Source,
          'Account Name': 'The University of Kansas',
          Labels: '',
          Notes: description,
        };
      }
    );
    fs.writeFileSync(
      'ku-payments-mint-like.json',
      JSON.stringify(newData, null, 2)
    );
  },
};

// Mapping Rocket Money categories to Copilot categories
const categoryMapping = {
  Groceries: 'Groceries',
  'Credit Card Payment': 'Internal Transfers',
  'Entertainment & Rec.': 'Entertainment',
  Shopping: 'Shops',
  'Dining & Drinks': 'Restaurants',
  'Bills & Utilities': 'Bills & Utilities',
  'Home & Garden': 'Home',
  Education: 'Education',
  'Internal Transfers': 'Internal Transfers',
  'Software & Tech': 'Software & Tech',
  'Auto & Transport': 'Transportation',
  'Travel & Vacation': 'Travel & Vacation',
  Fees: 'Fees',
  'Health & Wellness': 'Healthcare',
  'Personal Care': 'Personal Care',
  Gifts: 'Gifts',
  'Charitable Donations': 'Donations',
  Taxes: 'Taxes',
};

const incomeCategories = {
  Income: 'Income',
  Investment: 'Income',
  Cashback: 'Income',
  Grant: 'Income',
  Reimbursement: 'Income',
};

// Below, you can call any method from the steps object or chain several
// together - this makes it easy to run the migration a step at a time, without
// having to comment out any code, and while keeping things organized.

// steps.kuChargesToMint();
console.log('Done!');
