/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockVariation } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import { Icon } from './icon';

registerBlockVariation('core/embed', {
	name: 'wistia',
	title: 'Wistia',
	description: __('Embed a Wistia video.', 'wistia-embed-block'),
	icon: { src: Icon },
	patterns: [/https?:\/\/[^.]+\.(wistia\.com|wi\.st)\/(medias|embed)\/.*/],
	attributes: {
		providerNameSlug: 'wistia',
		responsive: true,
		type: 'video',
	},
	isActive: (attributes) => attributes.providerNameSlug === 'wistia',
});
