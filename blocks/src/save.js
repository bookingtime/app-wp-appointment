import { useBlockProps } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const { url,title } = attributes;

	return (
		<div { ...useBlockProps.save() }>
			<iframe src={ url } name={ title } className="bookingtime_iframe" ></iframe>
		</div>
	);
}
