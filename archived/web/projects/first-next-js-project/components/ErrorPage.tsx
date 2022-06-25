import Layout                       from '../components/Layout';
import Link                         from 'next/Link';
import React                        from 'react';
import LanguageContext              from './LanguageContext';
import { LanguageStringsStructure } from '../lib/languages';
import { CommonStrings }            from '../localization/global';

interface ErrorPageLocalization extends LanguageStringsStructure {
	'en-US': {
		header: string,
		message: string,
	},
}

const LanguageStrings: ErrorPageLocalization = {
	'en-US': {
		header: 'Oops! Nothing was found',
		message: `The page you are looking for might have been removed,
		had its name changed or is temporarily unavailable.`,
	},
};

const ErrorPage = ({errorCode = 404}: {errorCode?: number}) =>
	<LanguageContext.Consumer>
		{(language) =>
			<Layout>
				<head>
					<title>{errorCode}</title>
				</head>
				<div className="text-center">
					<h1 className='text-9xl py-2 text-indigo-300'>{errorCode}</h1>
					<h2>{LanguageStrings[language].header}</h2>
					<p>
						{LanguageStrings[language].message}
						<Link href="/">
							<a className='block pt-10'>
								{CommonStrings[language].return_to_homepage}
							</a>
						</Link>
					</p>
				</div>
			</Layout>
		}
	</LanguageContext.Consumer>;

export default ErrorPage;