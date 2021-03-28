import '../styles/tailwind.css';
import { AppProps }           from 'next/app';
import ErrorBoundary          from '../components/ErrorBoundary';
import { useRouter }          from 'next/router';
import React                  from 'react';
import LanguageContext        from '../components/LanguageContext';
import { AvailableLanguages } from '../lib/languages';

export default function App({Component, pageProps}: AppProps) {

	const {defaultLocale = 'en-US', locale = defaultLocale} = useRouter();

	return <ErrorBoundary>
		<LanguageContext.Provider value={locale as AvailableLanguages['type']}>
			<Component {...pageProps} />
		</LanguageContext.Provider>
	</ErrorBoundary>;
}

/*
* Features:
* swr for client-side data fetching
* .env.local for global env constants
* async/await instead of promises
* <Link
	href={{
		pathname: '/blog/[slug]',
		query: { slug: post.slug },
	}}
>
* don't export non-react components from react components! (they would cause an excess page reloads in development)
* use dynamic imports to speed up page load:
* const Fuse = (await import('fuse.js')).default; // for non react components
import dynamic from 'next/dynamic'  // for react components:

const DynamicComponentWithCustomLoading = dynamic(
	() => import('../components/hello'),
	{ loading: () => <p>...</p> }
)
*
* define css variables in a JS constants file
*
* */