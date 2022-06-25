import Head                         from 'next/head';
import Layout, { siteTitle }        from '../components/Layout';
import utilStyles                   from '../styles/utils.module.css';
import { getSortedPostsData, Post } from '../lib/posts';
import { GetStaticProps }           from 'next';


interface Props {
	allPostsData: Post[]
}

const Home = ({allPostsData}: Props) =>
	<Layout home>
		<Head>
			<title>{siteTitle}</title>
		</Head>
		<section className={utilStyles.headingMd}>
			<p>[Your Self Introduction]</p>
			<p>
				(This is a sample website - you’ll be building a site like this on{' '}
				<a href="https://nextjs.org/learn">our Next.js tutorial</a>.)
			</p>
		</section>
		<section className={`${utilStyles.headingMd} ${utilStyles.padding1px}`}>
			<h2 className={utilStyles.headingLg}>Blog</h2>
			<ul className={utilStyles.list}>
				{allPostsData.map(({id, date, title}) => (
					<li className={utilStyles.listItem} key={id}>
						{title}
						<br />
						{id}
						<br />
						{date}
					</li>
				))}
			</ul>
		</section>
	</Layout>;

export default Home;

export const getStaticProps: GetStaticProps<Props> = async () => {
	const allPostsData = getSortedPostsData();
	return {
		props: {
			allPostsData,
		},
	};
};