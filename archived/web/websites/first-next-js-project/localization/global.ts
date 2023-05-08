import { LanguageStringsStructure } from '../lib/languages';

interface CommonStringsLocalization extends LanguageStringsStructure {
	'en-US': {
		return_to_homepage: string,
	},
}

export const CommonStrings: CommonStringsLocalization = {
	'en-US': {
		return_to_homepage: '← Return to homepage',
	},
};