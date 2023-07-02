/**
 * A rough and overly optimistic calculation of an investment plan
 *
 * Conclusions based on this analysis:
 *  - Maintain a very healthy life style to live long
 *  - Make sure job is enjoyable and meaningful
 *  - Work on increasing salary
 *  - Work overtime
 *  - Maintain a very high savings rate
 */

// Initial amount in savings
const initialInvestment = 40_000;
// Estimated effective tax rate (averaged with tax advantaged accounts)
const taxRate = 0.24;
// After tax salary after benefits and overtime pay
const startSalary = 160_000 * (1 - taxRate);
// Assuming that salary growth at 10% per year
const salaryIncreasePerYear = 0.1;
// Assuming that 70% of salary is invested (frugal)
const savingsRate = 0.7;
// Assuming Fidelity 500 Index (S&P 500) returns
const returnRate = 0.1;
// Starting today
const startYear = new Date().getFullYear();
// Number of years to compute for
const computeForYears = 80;
// Average from 1960 to 2022
const inflationRate = 0.038;
const workHoursInYear = 2080;

const futureSalary = (year = startYear) =>
  startSalary * (1 + salaryIncreasePerYear) ** (year - startYear + 1);

const inflation = (amount, year) =>
  Math.round(amount * (1 - inflationRate) ** (year - startYear + 1));

const computeInvestment = () =>
  Array.from({
    length: computeForYears,
  }).reduce((history, _, index) => {
    const year = startYear + index;
    const salary = futureSalary(year);
    const contribution = salary * savingsRate;
    const startBalance = history.at(-1)?.updatedBalance ?? initialInvestment;
    const grownBalance = startBalance * (1 + returnRate);
    const growth = grownBalance - startBalance;
    const inflationGrowth = inflation(growth, year);
    const updatedBalance = grownBalance + contribution;
    const inflationUpdatedBalance = inflation(updatedBalance, year);
    return [
      ...history,
      {
        year,
        updatedBalance: Math.round(updatedBalance),
        salary: Math.round(salary),
        hourlySalary: Math.round((salary / workHoursInYear) * 100) / 100,
        contribution: Math.round(contribution),
        totalContribution: Math.round(
          (history.at(-1)?.totalContribution ?? 0) + contribution
        ),
        investmentAmount: Math.round(contribution),
        inflationGrowth,
        inflationUpdatedBalance,
        investmentHourlySalary:
          Math.round((growth / workHoursInYear) * 100) / 100,
      },
    ];
  }, []);

console.table(computeInvestment());
