import { __ } from '@wordpress/i18n';
import { useState, useEffect } from 'react';
import { useBlockProps } from '@wordpress/block-editor';
import './editor.scss';



export default function Edit( { attributes, setAttributes } ) {

	const { url, title } = attributes;
	const [services, setServices] = useState([]);

	let appointmentGlobals = require('../appointment_globals.json');
	let jsonUrl = appointmentGlobals.wp_home + '/wp-admin/admin.php?page=appointment-getbookingtimepageurls';

	useEffect(() => {
	fetch(jsonUrl)
		.then(res => res.json())
		.then(data => setServices(data));
	}, []);


	if(services.length > 0 && (url == undefined || title == undefined) ) {
		const selectedIndex = document.getElementById('bookingtime_url_select').options.selectedIndex;
		if(selectedIndex > -1) {
			setAttributes( { url: document.getElementById('bookingtime_url_select').options[selectedIndex].value } );
			setAttributes( { title: document.getElementById('bookingtime_url_select').options[selectedIndex].innerHTML } );
		}
	}

	function onChange( event ) {
		const selectElement = document.getElementById('bookingtime_url_select');
		const selectedOption = selectElement.options[selectElement.selectedIndex];
		setAttributes( { url: event.target.value } );
		setAttributes( { title: selectedOption.innerText } );
	}

	return (
	<div {...useBlockProps()}>
		<h4>bookingtime</h4>
		<select id="bookingtime_url_select" className="bookingtime_url_select" onChange={onChange} value={ url }>

		{

			services && services.length>0 && services.map((item)=><option value={item.url} >{item.title} - {item.url}</option>)

		}

		</select>
	</div>
	);

}
