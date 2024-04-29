import { registerBlockType } from '@wordpress/blocks';
import Edit from "./edit";
import Save from "./save";
import "./style.scss";
import $ from "jquery";

registerBlockType( 'bookingtime/appointment', {
	icon: {
		src: 'calendar',
		background: '#009add',
		foreground: '#002c6c'
	},
	edit: Edit,
	save: Save,
});
