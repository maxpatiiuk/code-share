import fs   from 'fs';
import path from 'path';

const postsDirectory = path.join(process.cwd(), 'posts');

export interface Post {
	title: string,
	id: string,
	date: string,
}

export function getAllPostIds() {
	const fileNames = fs.readdirSync(postsDirectory);

	// Returns an array that looks like this:
	// [
	//   {
	//     params: {
	//       id: 'ssg-ssr'
	//     }
	//   },
	//   {
	//     params: {
	//       id: 'pre-rendering'
	//     }
	//   }
	// ]
	return fileNames.map(fileName => {
		return {
			params: {
				id: fileName.replace(/\.md$/, ''),
			},
		};
	});
}

export function getSortedPostsData(): Post[] {
	// Get file names under /posts
	const fileNames = fs.readdirSync(postsDirectory);
	const allPostsData = fileNames.map(fileName => {
		// Remove ".md" from file name to get id
		const id = fileName.replace(/\.md$/, '');

		// Read markdown file as string
		// const fullPath = path.join(postsDirectory, fileName);
		// const fileContents = fs.readFileSync(fullPath, 'utf8');

		// Use gray-matter to parse the post metadata section
		const matterResult = {
			title: 'qwer',
			date: 'qqwer',
		};

		// Combine the data with the id
		return {
			id,
			...(
				matterResult as Omit<Post, 'id'>
			),
		};
	});
	// Sort posts by date
	return allPostsData.sort((a, b) => {
		if (a.date < b.date) {
			return 1;
		}
		else {
			return -1;
		}
	});
}

export function getPostData(id: string) {
	// const fullPath = path.join(postsDirectory, `${id}.md`);
	// const fileContents = fs.readFileSync(fullPath, 'utf8');

	// Use gray-matter to parse the post metadata section
	const matterResult = {
		title: 'qwer',
		date: 'qqwer',
	};

	// Combine the data with the id
	return {
		id,
		...matterResult,
	};
}