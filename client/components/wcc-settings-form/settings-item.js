import React, { PropTypes } from 'react';
import TextField from 'components/text-field';
import RadioButtons from 'components/radio-buttons';
import ShippingServiceGroups from 'components/shipping/services';
import { connect } from 'react-redux';
import * as SettingsActions from 'state/settings/actions';
import * as FormActions from 'state/form/actions';
import { bindActionCreators } from 'redux';
import Packages from 'components/shipping/packages';

const SettingsItem = ( { layout, schema, settings, settingsActions, storeOptions } ) => {
	const id = layout.key ? layout.key : layout;
	const updateValue = ( value ) => settingsActions.updateSettingsField( id, value );
	const updateSubSubValue = ( key, subKey, val ) => settingsActions.updateSettingsObjectSubField( id, key, subKey, val );

	switch ( layout.type ) {
		case 'radios':
			return (
				<RadioButtons
					layout={ layout }
					schema={ schema.properties[id] }
					value={ settings[id] }
					setValue={ updateValue }
				/>
			);

		case 'shipping_services':
			return (
				<ShippingServiceGroups
					services={ schema.definitions.services }
					settings={ settings[id] }
					currencySymbol={ storeOptions.currency_symbol }
					updateValue={ updateSubSubValue }
					settingsKey={ id }
				/>
			);

		case 'packages':
			return (
				<Packages />
			);

		default:
			return (
				<TextField
					id={ id }
					schema={ schema.properties[id] }
					value={ settings[id] }
					placeholder={ layout.placeholder }
					updateValue={ updateValue }
				/>
			);
	}
};

SettingsItem.propTypes = {
	layout: PropTypes.oneOfType( [
		PropTypes.string.isRequired,
		PropTypes.object.isRequired,
	] ).isRequired,
	schema: PropTypes.object.isRequired,
	settings: PropTypes.object.isRequired,
	storeOptions: PropTypes.object.isRequired,
};

function mapStateToProps( state ) {
	return {
		settings: state.settings,
		form: state.form,
	};
}

function mapDispatchToProps( dispatch ) {
	return {
		settingsActions: bindActionCreators( SettingsActions, dispatch ),
		formActions: bindActionCreators( FormActions, dispatch ),
	};
}

export default connect(
	mapStateToProps,
	mapDispatchToProps
)( SettingsItem );
