import * as React from 'react';

export const Section = ({
	title,
	children,
}:{
	title: string,
	children: React.ReactNode
}) =>
	<div className='py-4'>
		<h2 className='font-bold text-3xl'>{title}</h2>
		<span>{children}</span>
	</div>;

export const Subsection = ({
	title,
	children,
}:{
	title: string,
	children: React.ReactNode
}) =>
	<div className='py-3'>
		<h2 className='pb-1 font-bold text-xl'>{title}</h2>
		<span>{children}</span>
	</div>;