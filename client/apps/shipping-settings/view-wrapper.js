/**
 * External dependencies
 */
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { localize } from 'i18n-calypso';

/**
 * Internal dependencies
 */
// from calypso
import Button from 'components/button';
import GlobalNotices from 'components/global-notices';
import LabelSettings from 'woocommerce/woocommerce-services/views/label-settings';
import notices from 'notices';
import Packages from 'woocommerce/woocommerce-services/views/packages';
import { ProtectFormGuard } from 'lib/protect-form';
import { successNotice, errorNotice } from 'state/notices/actions';
import { createWcsShippingSaveActionList } from 'woocommerce/woocommerce-services/state/actions';
import { getSelectedSiteId } from 'state/ui/selectors';
import { getLabelSettingsFormMeta, getSelectedPaymentMethodId } from 'woocommerce/woocommerce-services/state/label-settings/selectors';
import { getPackagesForm } from 'woocommerce/woocommerce-services/state/packages/selectors';

class LabelSettingsWrapper extends Component {
	constructor( props ) {
		super( props );
		this.state = {
			pristine: true,
		};
	}

	onChange = () => {
		this.setState( { pristine: false } );
	}

	onSaveSuccess = () => {
		const { translate, orderId, orderHref, paymentMethodSelected } = this.props;
		const options =
			orderHref && paymentMethodSelected
				? { button: translate( 'Return to Order #%(orderId)s', { args: { orderId } } ), href: orderHref }
				: { duration: 5000 };

		this.setState( { pristine: true } );
		return this.props.successNotice( translate( 'Your shipping settings have been saved.' ), options );
	}

	onSaveFailure = () => {
		const { translate } = this.props;
		return this.props.errorNotice( translate( 'Unable to save your shipping settings. Please try again.' ) );
	}

	onPaymentMethodMissing = () => {
		const { translate } = this.props;
		return this.props.errorNotice(
			translate( 'A payment method is required to print shipping labels.' ),
			{
				duration: 4000,
			}
		);
	}

	onSaveChanges = () => {
		this.props.createWcsShippingSaveActionList(
			this.onSaveSuccess,
			this.onSaveFailure,
			this.onPaymentMethodMissing
		);
	}

	render() {
		const {
			translate,
			isSaving,
		} = this.props;

		return (
			<div>
				<GlobalNotices id="notices" notices={ notices.list } />
				<LabelSettings onChange={ this.onChange } />
				<Packages onChange={ this.onChange } />
				<Button
					primary
					onClick={ this.onSaveChanges }
					busy={ isSaving }
					disabled={ isSaving }
				>
					{ translate( 'Save changes' ) }
				</Button>
				<ProtectFormGuard isChanged={ ! this.state.pristine } />
			</div>
		);
	}
}

export default connect(
	state => {
		const labelsFormMeta = getLabelSettingsFormMeta( state );
		const packagesForm = getPackagesForm( state );

		return {
			siteId: getSelectedSiteId( state ),
			isSaving: labelsFormMeta.isSaving || packagesForm.isSaving,
			paymentMethodSelected: Boolean( getSelectedPaymentMethodId( state ) ),
		};
	},
	dispatch => bindActionCreators( {
		createWcsShippingSaveActionList,
		errorNotice,
		successNotice,
	}, dispatch )
)( localize( LabelSettingsWrapper ) );
