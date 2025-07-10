document.addEventListener('DOMContentLoaded', function() {
    (function(wp) {
        const registerBlockType = wp.blocks.registerBlockType;
        const el = wp.element.createElement;
        const __ = wp.i18n.__;
		const InnerBlocks = wp.blockEditor.InnerBlocks;

        function Edit(props) {
            return el(
                'section',
                { className: 'faq-accordion' },
                el(InnerBlocks, {
                    allowedBlocks: [ 'core/details' ],
                    template: [
						[ 'core/heading', { placeholder: __('FAQ Title', 'fooz') }],
						[ 'core/details', {} ]
					],
                    templateLock: false
                })
            );
        }

        function Save(props) {
            return el(
                'section',
                { className: 'faq-accordion' },
                el(InnerBlocks.Content)
            );
        }

        registerBlockType('fooz/faq-accordion', {
            edit: Edit,
            save: Save
        });
    })(window.wp);
});
