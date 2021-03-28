import { namedComponent } from '../lib/stateManagement';
import Modal              from 'react-modal';
import * as React         from 'react';
import css                from 'styled-jsx/css';

//grey - bg-white border border-gray-300 hover:bg-gray-50 px-4 py-2 rounded-md sm:text-sm sm:w-auto text-gray-700
//red - bg-red-600 hover:bg-red-700 inline-flex px-4 py-2 rounded-md sm:text-sm

export const ModalDialog = namedComponent(({
	isOpen = true,
	title,
	buttons = [],
	children,
	onCloseClick: handleCloseClick,
}: {
	isOpen?: boolean,
	title: string,
	onClose?: () => void,
	buttons: React.ReactNode,
	children: React.ReactNode,
	onCloseClick?: () => void,
}) => {

	const {className} = css.resolve``;

	Modal.setAppElement('#root');

	return <div className='modal-root'>
		<Modal
			isOpen={isOpen}
			closeTimeoutMS={100}
			contentLabel={title}
			style={{
				overlay: {
					opacity: 0,
					transition: 'opacity 100ms ease-in-out',
					width: '100vw',
					height: '100vh',
					position: 'absolute',
					inset: 0,
					display: 'flex',
					alignItems: 'center',
					justifyContent: 'center',
					background: '#0009',
				},
				content: {
					position: 'unset',
					inset: 'unset',
					border: 'unset',
					background: 'unset',
					overflow: 'unset',
					borderRadius: 'unset',
					outline: 'unset',
					padding: 'unset',
				},
			}}
			portalClassName={className}
			shouldCloseOnEsc={typeof handleCloseClick === 'function'}
		>
			<div className="bg-white shadow-xl w-auto w-1/2 m-auto">
				<div className="bg-gray-50 p-4 flex justify-between items-center">
					<h3 className="text-lg text-gray-900">
						{title}
					</h3>
					{
						handleCloseClick &&
						<div
							className="flex items-center justify-center rounded-full bg-red-100 sm:h-10 sm:w-10 cursor-pointer"
							onClick={handleCloseClick}
						>
							<svg
								className="h-6 w-6 text-red-600"
								fill="none"
								stroke="currentColor"
								viewBox="0 0 24 24"
								xmlns="http://www.w3.org/2000/svg"
							>
								<path
									strokeLinecap="round"
									strokeLinejoin="round"
									strokeWidth="2"
									d="M6 18L18 6M6 6l12 12" />
							</svg>
						</div>
					}
				</div>
				<div className="p-4 text-sm text-gray-500">
					{children}
				</div>
				<div className="bg-gray-50 flex justify-end p-4 gap-x-2">
					{buttons}
				</div>
			</div>
		</Modal>
		<style jsx global>{`
			.${className} > :global(.ReactModal__Overlay--after-open) {
				opacity: 1 !important;
			}

			.${className} > :global(.ReactModal__Overlay--before-close) {
				opacity: 0 !important;
			}
		`}</style>
	</div>;
}, 'ModalDialog');