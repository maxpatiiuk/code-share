import { Action } from './stateManagement';

export type AvailableLanguages = Action<'en-US'>

export type LanguageStringsStructure = {
	readonly [language in AvailableLanguages['type']]: Record<string, string | number | Function>
}
