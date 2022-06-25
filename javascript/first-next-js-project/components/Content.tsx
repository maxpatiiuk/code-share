import { Section, Subsection } from './UI';

const Content = ()=>
	<div className='p-4'>
		<Section title='Core'>
			<Subsection title='Colors'>
				<table className='table-auto text-center'>
					<tr>
						<td>
							bg<br />
							text<br />
							border<br />
							divide (like border, but auto)<br />
							ring (semi transparent border)<br />
							ring-offset (secondary inner ring)<br />
							placeholder<br />
							from (for gradients)<br />
							via (for gradients)<br />
							to (for gradients)
						</td>
						<td>-</td>
						<td>
							transparent<br />
							current<br />
							black<br />
							white<br />
							gray<br />
							red<br />
							yellow<br />
							green<br />
							blue<br />
							indigo<br />
							purple<br />
							pink<br />
						</td>
						<td>-</td>
						<td>
							50<br />
							100<br />
							200<br />
							300<br />
							400<br />
							500<br />
							600<br />
							700<br />
							800<br />
							900<br />
						</td>
					</tr>
				</table>
				<p>bg-opacity- text-opacity- placeholder-opacity-100 75 50 25 0 (pair with hover: focus:)</p>
			</Subsection>
			<Subsection title='Opacity'>
				<table className="table-auto text-center">
					<tr>
						<td>
							&lt;blank&gt;<br />
							bg<br />
							text<br />
							border<br />
							divide<br />
							ring<br />
							placeholder<br />
							(...combine with :hover :focus)
						</td>
						<td>-opacity-</td>
						<td>
							0<br />
							5<br />
							10<br />
							20<br />
							25<br />
							30<br />
							40<br />
							50<br />
							60<br />
							70<br />
							75<br />
							80<br />
							90<br />
							100<br />
						</td>
					</tr>
				</table>
			</Subsection>
			<Subsection title='Misc'>
				<p className='font-bolder'>add -none to disable property</p>
			</Subsection>
			<Subsection title='Variants'>
				<p>Common variants - hover: focus: active: and focus-visible: for a keyboard-only focus</p>
				<p>
					disabled: visited: checked: first: last: odd: even: <span className='font-bold'>dark:</span>
				</p>
				<div>If parent has `group`, then can use group-hover: and group-focus: on children</div>
				<div>If child has focus, can use focus-within: on parent</div>
			</Subsection>
			<Subsection title='Offsets'>
				<p>p-4 px-4 py-4 pb-4</p>
				<p>m-4 px-4 my-4 mb-4 -m-4 -m-b-1</p>
			</Subsection>
		</Section>
		<Section title='Containers'>
			<Subsection title='General'>
				<p>
					Design pages mobile first: no prefix everywhere, and then start adding sm: md: lg: xl: 2xl:
				</p>
				<p>`container` class sets max-width to min-width of the current breakpoint</p>
				<p>object-fit to control child's size</p>
				<p>visible/invisible</p>
				<p>w- w-auto w-1/2 w-full min-w- max-w-</p>
			</Subsection>
			<Subsection title='Grid'>
				<p>grid-cols-{'{n}'} col-span-2 gap-x-2</p>
				<p>col-start-2 con-span-4 / col-start-1 con-end-3</p>
				<p>grid-flow-col to fill grid col by col, instead of row by row</p>
				<p>auto-cols-auto auto-cols-min auto-cols-max auto-cols-fr</p>
				<p>
					justify- (items in a container) justify-items- (items in their own "cell")
					justify-self- (-items but individually
				</p>
				<p>align- (same) and place-content- (combine align- and justify-)</p>
				<p>space- (like gap)</p>
			</Subsection>
		</Section>
		<Section title='Text'>
			<Subsection title='Main'>
				<p>font-sans font-serif font-mono italic</p>
				<p>text-xs / sm base lg xl 2xl-9xl</p>
				<p>font-thin / extralight light normal medium semibold bold extrabold black</p>
			</Subsection>
			<Subsection title='Formatting'>
				<p>Letter spacing: tracking-tighter / tight normal wide wider widest</p>
				<p>Line height: fixed: leading-3 (-10) / relative: none tight snug normal relaxed loosed</p>
				<p>list-none disc decimal. dot position: list-inside -outside</p>
				<p>no-underline uppercase lowercase capitalize normal-case</p>
				<p>Text overflow: truncate overflow-ellipsis overflow-clip</p>
				<p>for cells and inline: vertical: align-baseline top middle bottom text-top text-bottom</p>
				<p>whitespace- text: break-</p>
			</Subsection>
			<Subsection title='Special features'>
				<p className='ordinal'>1st (.ordinal)</p>
				<p className='slashed-zero'>0 (.slashed-zero)</p>
				<p className='proportional-nums'>12121 (.proportional-nums - monospace like)</p>
				<p className='proportional-nums'>90909</p>
				<p className='tabular-nums'>12121 (.tabular-nums - tab aligned width)</p>
				<p className='tabular-nums'>90909</p>
				<p className='diagonal-fractions'>1/2 3/4 5/6 (.diagonal-fractions)</p>
			</Subsection>
		</Section>
		<Section title='Background'>
			<Subsection title='Image'>
				<p>bg-fixed local scroll</p>
				<p className='font-bold'>bg-clip-border padding content text (text - clip bg though text</p>
				<p>bg-bottom top right-bottom ...</p>
				<p>bg-repeat no-repeat repeat-x repeat-y repeat-round repeat-space</p>
				<p>bg-cover contain -auto</p>
			</Subsection>
			<Subsection title='Gradient'>
				<p>bg-gradient-to-t tr t br b bl l tl</p>
			</Subsection>
		</Section>
		<Section title='Outlines'>
			<Subsection title='Rounding'>
				<p>rounded rounded-sm md lg xl 2xl 3xl full rounded-t-2xl rounded-bl-none</p>
			</Subsection>
			<Subsection title='Border'>
				<p>Size: border border-0 2 4 8 border-r-8 border-t</p>
				<p>border-solid dashed dotted double none</p>
			</Subsection>
			<Subsection title='Divide'>
				<p>Add borders between horizontal/vertical children:</p>
				<p className='font-bold'>divide-y-0 2 4 8 divide-x-2</p>
				<p>If order of children is reversed, use divide-x/y-reverse</p>
				<p>divide-solid dashed dotted double none</p>
			</Subsection>
			<Subsection title='Ring'>
				<p>ring ring-0 1 2 4 8</p>
				<p>ring-inset - like box-sizing border-box</p>
				<p>ring-offset-0 1 2 4 8 - secondary ring</p>
			</Subsection>
			<Subsection title='Shadow'>
				<p>shadow shadow-sm md lg xl 2xl <span className='font-bold'>inner</span> none</p>
			</Subsection>
			<Subsection title='Table Border Collapse'>
				<p>border-collapse border-separate</p>
			</Subsection>
			<Subsection title='Outline'>
				<p>outline-none white black</p>
			</Subsection>
		</Section>
		<Section title='Table'>
			<p>table-auto - auto size columns</p>
			<p>table-fixed - listen to w-1/2 or other property</p>
		</Section>
		<Section title='Animations'>
			<Subsection title='Transition'>
				<p className='font-bold'>
					transition (main) transition-none all colors opacity shadow transform
				</p>
				<p>duration-75 100 150 200 300 500 700 1000</p>
				<p>ease-linear in out in-out</p>
				<p>delay-75 100 150 200 300 500 700 1000</p>
			</Subsection>
			<Subsection title='Animate'>
				<p>animate-none</p>
				<p>animate-spin - rotating 360deg</p>
				<p>animate-ping - scale</p>
				<p>animate-pulse - opacity</p>
				<p>animate-bounce - move up/down</p>
				<p className='font-bold'>motion-safe:animate-bounce motion-reduce:animate-bounce</p>
			</Subsection>
		</Section>
		<Section title='Transforms'>
			<Subsection title='Enabling transforms'>
				<p>transform - add this to enable transforms</p>
				<p>transform-gpu - enable transforms and use GPU acceleration</p>
			</Subsection>
			<Subsection title='Transforms'>
				<p>origin-center top top-right right bottom...</p>
				<p>scale-0 50 75 90 95 100 105 110 125 150 scale-x-50 scale-y-50</p>
				<p>rotate-0 1 2 3 6 12 45 180 -rotate-45 90 45 12 6 3 2 1</p>
				<p>translate-x-0 0.4 1 1.5 2 2.5 3 3.5 4 px 1/2 full -translate-y-5</p>
				<p>skew-x-0 1 2 3 6 12 -skew-y-3</p>
			</Subsection>
		</Section>
		<Section title='Interactivity'>
			<p className='font-bold'>appearance-none - reset browser specific el styles</p>
			<p>cursor-auto default pointer wait text move not-allowed</p>
			<p>pointer-events-none pointer-events-auto</p>
			<p>resize resize-none y x</p>
			<p>Selection: select-none text <span className='font-bold'>all (all on any click)</span> auto</p>
		</Section>
		<Section title='Svg'>
			<p>fill-current - fill SVG with current text color</p>
			<p>stroke-current - stroke (border) SVG with current text color (e.x. text-green-200)</p>
			<p>stroke-0 1 2 - stroke size</p>
		</Section>
		<Section title='Accessibility'>
			<p>sr-only (hides el from all but screen readers) not-sr-only</p>
		</Section>
		<Section title='Plugins'>
			<p>tailwindcss-aspect-ratio - force el into an aspect ratio</p>
		</Section>
	</div>;

export default Content;