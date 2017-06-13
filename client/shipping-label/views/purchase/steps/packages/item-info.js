import React, { PropTypes } from 'react';
import { translate as __ } from 'i18n-calypso';
import Button from 'components/button';

const ItemInfo = ( { item, itemIndex, openItemMove } ) => {
	const renderMoveToPackage = () => {
		return (
			<Button className="wcc-package-item__move" compact onClick={ () => openItemMove( itemIndex ) }>
				{ __( 'Move' ) }
			</Button>
		);
	};

	return (
		<div key={ itemIndex } className="wcc-package-item">
			<div className="wcc-package-item__name">
					<span className="wcc-package-item__title">
						{ item.url
							? <a href={ item.url } target="_blank">{ item.name }</a>
							: item.name
						}
					</span>
				{ item.attributes && <p>{ item.attributes }</p> }
			</div>
			<div className="wcc-package-item__actions">
				{ renderMoveToPackage() }
			</div>
		</div>
	);
};

ItemInfo.propTypes = {
	item: PropTypes.object.isRequired,
	itemIndex: PropTypes.number.isRequired,
	openItemMove: PropTypes.func.isRequired,
};

export default ItemInfo;
