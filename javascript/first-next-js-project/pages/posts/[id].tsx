import Layout                               from '../../components/Layout';
import { getAllPostIds, getPostData, Post } from '../../lib/posts';
import Head                                 from 'next/head';
import { GetStaticPaths, GetStaticProps }   from 'next';
import { ModalDialog }                      from '../../components/ModalDialog';
import * as React                           from 'react';

const PostContent = ({postData}: {postData: Post}) =>
	<Layout>
		<Head>
			<title>{postData.title}</title>
		</Head>
		{postData.title}
		<br />
		{postData.id}
		<br />
		{postData.date}
		<ModalDialog
			title='Remove your account?'
			onCloseClick={() => alert('1')}
			buttons={<>
				<button
					type="button"
					className="bg-white border border-gray-300 hover:bg-gray-50 px-4 py-2 rounded-md sm:text-sm sm:w-auto text-gray-700"
				>
					Cancel
				</button>
				<button
					type="button"
					className="bg-red-600 hover:bg-red-700 inline-flex px-4 py-2 rounded-md sm:text-sm"
				>
					Deactivate
				</button>
			</>}
		>
			Are you sure you want to deactivate your account? All of your data will be permanently removed.
			This action cannot be undone.
		</ModalDialog>
	</Layout>;

export default PostContent;

export const getStaticPaths: GetStaticPaths = async () => {
	const paths = getAllPostIds();
	return {
		paths,
		fallback: false,
	};
};

export const getStaticProps: GetStaticProps = async ({params}) => {
	const postData = getPostData(params.id);
	return {
		props: {
			postData,
		},
	};
};