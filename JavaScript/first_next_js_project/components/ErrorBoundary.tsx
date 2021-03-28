/*
*
* Error Boundary for React Components. Catches exceptions and provides a stack trace
*
* */

'use strict';

import React           from 'react';
import { ModalDialog } from './ModalDialog';

type ErrorBoundaryState =
	{
		has_error: false,
	} | {
	has_error: true,
	error: {toString: () => string},
	errorInfo: {componentStack: string}
};

export default class ErrorBoundary extends React.Component<{children: JSX.Element}, ErrorBoundaryState> {
	state: ErrorBoundaryState = {
		has_error: false,
	};

	componentDidCatch(error: {toString: () => string}, errorInfo: {componentStack: string}): void {
		console.log(error, errorInfo);
		this.setState({
			has_error: true,
			error,
			errorInfo,
		});
	}

	render(): JSX.Element {
		if (this.state.has_error)
			return <ModalDialog
				title={'Unexpected Error'}
				buttons={<>
					<button
						type="button"
						className="bg-white border border-gray-300 hover:bg-gray-50 px-4 py-2 rounded-md sm:text-sm sm:w-auto text-gray-700"
					>

					</button>
					<button
						type="button"
						className="bg-red-600 hover:bg-red-700 inline-flex px-4 py-2 rounded-md sm:text-sm"
						onClick={window.location.reload}
					>
						Reload
					</button>
					<button
						type="button"
						className="bg-red-600 hover:bg-red-700 inline-flex px-4 py-2 rounded-md sm:text-sm"
						onClick={window.history.back}
					>
						Previous page
					</button>
				</>}
			>
				<p>An unexpected error has occurred.</p>
				<details style={{whiteSpace: 'pre-wrap'}}>
					{this.state.error && this.state.error.toString()}
					<br />
					{this.state.errorInfo.componentStack}
				</details>
			</ModalDialog>;
		else
			return this.props.children;
	}
}