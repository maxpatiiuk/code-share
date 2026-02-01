'use strict';
(() => {
  watchBody();

  // Find the table
  function watchBody() {
    const cleanup = handleChange(document.body, () => {
      const table = document.querySelector('#ListEditTable') ?? undefined;
      if (table === undefined) return;
      cleanup();
      watchTable(table);
    });
  }

  // Listen for children changes at most once per second
  function handleChange(element, callback) {
    const observer = new MutationObserver(throttle(callback, 1000));
    observer.observe(element, { childList: true, subtree: true });
    return () => observer.disconnect();
  }

  function throttle(callback, wait) {
    let timeout;
    let previousTimestamp = 0;

    function later() {
      previousTimestamp = Date.now();
      timeout = undefined;
      callback();
    }

    return () => {
      const now = Date.now();
      const remaining = wait - (now - previousTimestamp);
      if (remaining <= 0 || remaining > wait) {
        if (timeout !== undefined) {
          clearTimeout(timeout);
          timeout = undefined;
        }
        previousTimestamp = now;
        callback();
      } else if (timeout === undefined) timeout = setTimeout(later, remaining);
    };
  }

  // Update overtime hours on table change
  function watchTable(table) {
    handleChange(table, update.bind(undefined, table));
    addStyle(`
          tr.totals > th.border-left:after {
            content: var(--content);
          }
        `);
  }

  function addStyle(css) {
    const id = 'compute-overtime-hours';
    const style =
      document.getElementById(id) ||
      (function () {
        const style = document.createElement('style');
        style.type = 'text/css';
        style.id = id;
        document.head.appendChild(style);
        return style;
      })();
    const sheet = style.sheet;
    sheet.insertRule(css, (sheet.rules || sheet.cssRules || []).length);
  }

  const baseHours = 8;
  const weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];

  // Update overtime hours
  function update(table) {
    let daysPassed = 0;
    const cells = Array.from(table.querySelectorAll('tr.totals th'));

    cells.forEach((totalCell, index, { length }) => {
      const hours = Number.parseFloat(totalCell.textContent);

      const rawDayOfWeek = table.querySelector(
        `thead th:nth-child(${index + 1})`
      ).textContent;
      const isWeekDay = weekDays.some((day) => rawDayOfWeek.includes(day));
      if (isWeekDay && hours !== 0) daysPassed += 1;

      const isTotalColumn = index + 1 === length;
      if (!isTotalColumn) return;

      const standardHours = daysPassed * baseHours;
      const overtimeHours = hours - standardHours;
      const round = 60 /*min */ / 15; /* min = 4 */
      const overtimePerDay =
        Math.round((overtimeHours / daysPassed) * round) / round;
      console.log({
        standardHours,
        overtimeHours,
        round,
        overtimePerDay,
        previouTextContent: totalCell.textContent,
      });

      totalCell.style.setProperty(
        '--content',
        overtimeHours === 0 ? '' : `" - ${overtimeHours} (${overtimePerDay})"`
      );
    });
  }
})();
