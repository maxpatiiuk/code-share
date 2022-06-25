import ErrorPage           from '../components/errorPage';
import React               from 'react';
import { NextPageContext } from 'next';

const Error = ({statusCode}: {statusCode: number})=>
	<ErrorPage errorCode={statusCode} />;

Error.getInitialProps = ({res, err}: NextPageContext) => (
	{
		statusCode: res ?
			res.statusCode :
			err ?
				err.statusCode :
				404,
	}
);

export default Error;