/*
 * This script scraps Wikipedia page for a list of common unicode
 * characters.
 *
 * Usage:
 * 1. Open this URL in your browser:
 *    https://en.wikipedia.org/wiki/List_of_Unicode_characters
 * 2. Open DevTools Console
 * 3. Paste the content of this file into the console and hit ENTER
 * 4. Right click on the resulting object and press "Copy object".
 * 5. Open a new file and hit paste
 */

categoriesToExclude = [
  'Alphabetic Presentation Forms',
  'Arrows',
  'Block Elements',
  'Box Drawing',
  'Control codes',
  'Enclosed Alphanumerics',
  'External links',
  'Geometric Shapes',
  'Miscellaneous Symbols',
  'IPA Extensions',
  'Symbols for Legacy Computing',
  'Deprecated',
  'Miscellaneous Technical',
  'African clicks',
];

categoriesToRename = {
  'ASCII Digits': 'Numbers',
  'Number Forms': 'Numbers',
  'ASCII Punctuation & Symbols': 'Common',
  'Latin Alphabet: Lowercase': 'Common',
  'Latin Alphabet: Uppercase': 'Common',
  'General Punctuation': 'Extra Punctuation',
  'Latin Extended Additional': 'Latin Additional',
  Romanian: 'Latin Additional',
  'Slovenian & Croatian': 'Latin Additional',
  Croatian: 'Latin Additional',
  Pinyin: 'Latin Additional',
  Livonian: 'Latin Additional',
  Sinology: 'Latin Additional',
  'Latin-1 Punctuation & Symbols': 'Extra Punctuation',
  'Mathematical symbols': 'Math',
  'Letters: Uppercase': 'European Latin',
  'Letters: Lowercase': 'European Latin',
  'Unicode symbols': 'Extra Punctuation',
  'Spacing modifier letters': 'Extra Punctuation',
  'Greek Extended': 'Greek and Coptic',
  'Non-European & historic Latin': 'Phonetic & historic letters',
};

elements = Array.from(
  document.getElementsByClassName('mw-parser-output')[0].children
).filter((child) => ['H2', 'H3', 'TABLE'].includes(child.tagName));

header = undefined;
subHeader = undefined;
table = undefined;
groups = {};

t = (cell) =>
  cell ? (cell.innerText ?? cell.textContent).trim().replace(/\s+/g, ' ') : '';

isPrintable = (glyph) => [...glyph].length === 1;

elements.forEach((element) => {
  if (element.tagName === 'H2') {
    header = t(element.getElementsByClassName('mw-headline')[0]);
    subHeader = undefined;
  } else if (element.tagName === 'H3')
    subHeader = t(element.getElementsByClassName('mw-headline')[0]);
  else {
    if (
      typeof header === 'undefined' ||
      categoriesToExclude.includes(header) ||
      categoriesToExclude.includes(subHeader)
    )
      return;
    groups[subHeader ?? header] = element;
    subHeader = undefined;
  }
});

result = Object.entries(groups)
  .map(([groupName, table]) => {
    const headerRow = table.getElementsByTagName('thead')[0];
    let result;
    if (typeof headerRow === 'undefined') {
      result = {
        '': Array.from(table.getElementsByTagName('td'))
          .filter((td) => td.title && td.title !== 'Reserved')
          .map((cell) => {
            const [code, description] = cell.title.split(': ');
            const glyph = cell.innerText;
            if (!isPrintable(glyph)) return undefined;
            return { code, glyph, description };
          })
          .filter((glyph) => glyph),
      };
    } else {
      let headers = Array.from(headerRow.children[0].children, (element) =>
        t(
          Array.from(element.childNodes).find(
            (node) => node.nodeName === '#text'
          )
        )
      );
      const hasSubCategory = headers[0] === '';

      if (!hasSubCategory) headers = ['', ...headers];

      let subCategory = '';
      result = Array.from(
        table.getElementsByTagName('tbody')[0].children,
        (row) => {
          const rowHasSubCategory = row.children[0].align === 'center';
          if (rowHasSubCategory) subCategory = t(row.children[0]);

          const code = t(
            row.children[headers.indexOf('Code') - !rowHasSubCategory]
          );
          const glyph =
            row.children[headers.indexOf('Glyph') - !rowHasSubCategory]
              .innerText;
          const decimal = t(
            headers.indexOf('Decimal') === -1
              ? undefined
              : row.children[headers.indexOf('Decimal') - !rowHasSubCategory]
          );
          const description = t(
            row.children[headers.indexOf('Description') - !rowHasSubCategory]
          );
          if (!isPrintable(glyph)) return undefined;
          return {
            subCategory,
            code,
            glyph,
            description,
            ...(decimal ? { decimal } : {}),
          };
        }
      )
        .filter((glyph) => glyph)
        .reduce((categories, { subCategory, ...rest }) => {
          categories[subCategory] ??= [];
          categories[subCategory].push(rest);
          return categories;
        }, {});
    }

    return [groupName, result];
  })
  .reduce((result, [categoryName, subCategories]) => {
    Object.entries(subCategories).map(([subCategory, glyphs]) => {
      const header = subCategory || categoryName;
      const mappedHeader = categoriesToRename[header] ?? header;
      if (!categoriesToExclude.includes(header))
        result[mappedHeader] = [...(result[mappedHeader] ?? []), ...glyphs];
    });
    return result;
  }, {});

compressedResult = Object.fromEntries(
  Object.entries(result).map(([label, entries]) => [
    label,
    Object.entries(
      // Make `code` values unique
      Object.fromEntries(entries.map(({ code, ...rest }) => [code, rest]))
    ).map(([code, entry]) => [
      // Turns dictionaries into arrays to reduce JSON object size
      code,
      entry.glyph,
      entry.description,
      ...(entry.decimal ? [Number.parseInt(entry.decimal)] : []),
    ]),
  ])
);

console.log(compressedResult);
