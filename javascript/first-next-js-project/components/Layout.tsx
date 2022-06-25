import Head       from 'next/head';
import utilStyles from '../styles/utils.module.css';
import Link       from 'next/Link';
import React      from 'react';
import Image      from 'next/Image';

const name = 'Your Name';
export const siteTitle = 'Next.js Sample Website';

const Layout = ({children, home}: {children: React.ReactNode, home?: boolean}) =>
	<div id='root'>
		<Head>
			<link rel="icon" href="/favicon.ico" />
			<meta
				name="description"
				content="Learn how to build a personal website using Next.js"
			/>
			<meta
				property="og:image"
				content={`https://og-image.now.sh/${encodeURI(
					siteTitle,
				)}.png?theme=light&md=0&fontSize=75px&images=https%3A%2F%2Fassets.vercel.com%2Fimage%2Fupload%2Ffront%2Fassets%2Fdesign%2Fnextjs-black-logo.svg`}
			/>
			<meta name="og:title" content={siteTitle} />
			<meta name="twitter:card" content="summary_large_image" />
		</Head>
		<header className='header'>
			{home ? (
				<>
					<Image
						src="/images/profile.png"
						className={`headerHomeImage ${utilStyles.borderCircle}`}
						alt={name}
						width={100}
						height={100}
					/>
					<h1 className={utilStyles.heading2Xl}>{name}</h1>
				</>
			) : (
				<>
					<Link href="/">
						<a>
							<Image
								src="/images/profile.png"
								className={`headerHomeImage ${utilStyles.borderCircle}`}
								alt={name}
								width={100}
								height={100}
							/>
						</a>
					</Link>
					<h2 className={utilStyles.headingLg}>
						<Link href="/">
							<a className={utilStyles.colorInherit}>{name}</a>
						</Link>
					</h2>
				</>
			)}
		</header>
		<main>{children}</main>
		<style jsx>{`
				#root {
					max-width: 36rem;
					padding: 0 1rem;
					margin: 3rem auto 6rem;
				}

				.header {
					display: flex;
					flex-direction: column;
					align-items: center;
				}

				.headerImage {
					width: 6rem;
					height: 6rem;
				}

				.headerHomeImage {
					width: 8rem;
					height: 8rem;
				}

				.backToHome {
					margin: 3rem 0 0;
				}

			`}</style>
	</div>;

export default Layout;