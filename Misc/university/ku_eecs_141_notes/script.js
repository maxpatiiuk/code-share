// ==UserScript==
// @name     BB Custom Save&Load for tests
// @namespace http://tampermonkey.net/
// @version   0.1
// @description  This script let's use save the questions from the test to json, validate them and to automatically fill out the answers from clipboard. Clipboard can contain several JSON dictionaries in the form {"test_1_question_1":[],...}{"test_2_question_1":[],... 
// @author     You and me
// @match   https://courseware.ku.edu/webapps/assessment/*
// @grant   none
// ==/UserScript==
(function() {

	function get_id(element) {

		const original_id = element.getAttribute('id');
		const id_parts = original_id.split('_');

		let new_parts;
		if (id_parts.slice(-2, -1)[0].length > 2)
			new_parts = id_parts.slice(-1);
		else
			new_parts = id_parts.slice(-2);

		return new_parts.join('_');

	}

	function save() {
		const results = {};

		function handle_row(row) {

			const input = row.getElementsByTagName('input')[0];
			console.log(input);
			if (typeof input === "undefined")
				return {};

			const input_id = get_id(input);
			const checked = input.checked;
			const text = row.innerText.trim();

			return {
				'name': text,
				'value': {
					'checked': checked,
					'id': input_id
				}
			};

		}

		for (const question of document.getElementsByClassName('takeQuestionDiv')) {

			const name = question.getElementsByClassName('legend-visible')[0].innerText.trim();

			const result = {};

			const table = question.getElementsByTagName('table')[0];

			if (typeof table !== "undefined")
				for (const row of table.getElementsByTagName('tr')) {

					if (typeof result.table === "undefined")
						result.table = {};

					const {
						name,
						value
					} = handle_row(row);
					result.table[name] = value;

				}

			const fieldset = question.getElementsByTagName('fieldset')[0];
			const children = Object.values(fieldset.children);
			const lines = fieldset.querySelectorAll('p');
			console.log(lines);

			for (const line of lines) {

				if (typeof result.lines === "undefined")
					result.lines = {};

				const {
					name,
					value
				} = handle_row(line);
				if (typeof name !== "undefined")
					result.lines[name] = value;

			}

			const inputs = children.filter(children => children.tagName === 'INPUT')

			for (const input of inputs) {
				const input_id = get_id(input);
				if (typeof result.inputs === "undefined")
					result.inputs = {};
				result.inputs[input_id] = input.value;
			}

			results[name] = result;

		}

		return JSON.stringify(results, null, "\t");
	}

	function load(object) {

		object = identify(object);
		let question_id;

		function get_full_id(id) {
			return question_id + '_' + id;
		}

		function implement_rows(rows) {
			if (typeof rows !== "undefined")
				for (const [, {
						checked,
						id
					}] of Object.entries(rows)) {
					const row = document.querySelector('input[id$="' + get_full_id(id) + '"]');
					if (typeof row != "undefined")
						row.checked = checked;
				}
		}

		for (const [name, data] of Object.entries(object)) {

			question_id = data.id;

			if (typeof data.result !== "undefined") {
				const question = document.getElementById(question_id + '_1');
				const h3 = question.getElementsByTagName('h3')[0];
				const next = h3.nextElementSibling;
				if (next.tagName === 'SPAN')
					next.innerText += data.result;
				else
					h3.outerHTML += '<span>' + data.result + '</span>';
			}

			implement_rows(data.table);
			implement_rows(data.lines);

			if (typeof data['inputs'] !== "undefined")
				for (const [input_id, input_value] of Object.entries(data.inputs)) {
					const input = document.querySelector('input[id$="' + get_full_id(input_id) + '"]');
					if (typeof input != "undefined")
						input.value = input_value;
				}

		}

	}

	function copy(str) {
		const el = document.createElement('textarea');
		el.value = str;
		document.body.appendChild(el);
		el.select();
		document.execCommand('copy');
		document.body.removeChild(el);
	}

	function paste(callback) {
		navigator.clipboard.readText().then(text => {

			const objects = text.replace('}{', '}`_`_`{').split('`_`_`');
			let object;

			for (const separate_object of objects)
				object = {
					...object,
					...JSON.parse(separate_object)
				};

			callback(object);
		});
	}

	function validate(object) {

		object = identify(object);

		for (const [name, data] of Object.entries(object)) {

			const question_id = data.id;

			const question = document.querySelector('li[id$="' + question_id + '_1"]');

			const images = question.getElementsByClassName('reviewTestSubCellForIconBig')[0].getElementsByTagName('img')[0];
			let result = '';
			if (typeof images !== "undefined")
				result = images.getAttribute('alt');
			else {
				const grade_raw = question.getElementsByClassName('taskbuttondiv')[0].innerText;
				const [my_grade, target_grade_raw] = grade_raw.split(' out of ');
				const target_grade = target_grade_raw.replace(' points', '')
				if (my_grade === target_grade)
					result = 'Correct';
				else if (my_grade === 0)
					result = 'Incorrect';
				else
					result = 'Partial';
			}

			data.result = result;
			data.id = undefined;

			object[name] = data;

		}

		return JSON.stringify(object, null, "\t");

	}

	function identify(object) {

		const question_container = document.getElementById('content_listContainer');
		let elements;
		let page;

		if (typeof content_listContainer === "undefined")
			page = 'test';
		else
			page = 'results';

		if (page == 'test')
			elements = document.getElementsByClassName('takeQuestionDiv');
		else
			elements = question_container.getElementsByTagName('li');

		const questions = {};
		for (const question of elements) {

			const name = question.getElementsByClassName('vtbegenerated')[0].innerText.trim();
			let id = question.getAttribute('id');

			if (page === 'results')
				id = id.replace('contentListItem:', '');

			id = id.slice(0, -2);

			if (typeof object[name] !== "undefined")
				questions[name] = id;

		}

		for (const [question_name, ] of Object.entries(object)) {
			if (typeof questions[question_name] !== "undefined")
				object[question_name].id = questions[question_name];
		}

		return object;

	}

	function initialize() {

		const navbar = document.getElementById('bottom_submitButtonRow');
		const back_link = document.getElementsByClassName('backLink');

		if (navbar != null) {
			navbar.innerHTML = `<button type="button" id="save_to_clipboard" class="button-3">Save to clipboard</button>
        <button type="button" id="load_from_clipboard" class="button-3">Load from clipboard</button>` + navbar.innerHTML;

			document.getElementById('save_to_clipboard').addEventListener('click', (e) => {
				copy(save());
			});

			document.getElementById('load_from_clipboard').addEventListener('click', (e) => {
				paste(load);
			});
		} else if (back_link.length !== 0) {

			back_link[0].innerHTML = `<button type="button" id="validate_from_clipboard" class="button-3">Validate from clipboard</button>` + back_link[0].innerHTML;

			document.getElementById('validate_from_clipboard').addEventListener('click', (e) => {
				paste((text) => {
					copy(validate(text));
				});
			});

		}
	}

	initialize();

})();
