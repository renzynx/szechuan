@assets
<link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
<script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
@endassets
@script
    <script>
        const editor = new EasyMDE({
            element: document.getElementById('editor'),
            spellChecker: false,
            previewImagesInEditor: true,
            uploadImage: true,
            autoDownloadFontAwesome: false,
            status: [{
                className: 'upload-image',
                defaultValue: '',
            }],
            toolbar: [{
                    name: 'bold',
                    action: EasyMDE.toggleBold,
                }, {
                    name: 'italic',
                    action: EasyMDE.toggleItalic,
                }, {
                    name: 'strikethrough',
                    action: EasyMDE.toggleStrikethrough,
                }, {
                    name: 'link',
                    action: EasyMDE.drawLink,
                }, '|',
                {
                    name: 'heading',
                    action: EasyMDE.toggleHeadingSmaller,
                }, '|',
                {
                    name: 'quote',
                    action: EasyMDE.toggleBlockquote,
                }, {
                    name: 'code',
                    action: EasyMDE.toggleCodeBlock,

                }, {
                    name: 'unordered-list',
                    action: EasyMDE.toggleUnorderedList,
                }, {
                    name: 'ordered-list',
                    action: EasyMDE.toggleOrderedList,
                }, '|',
                {
                    name: 'upload-image',
                    action: EasyMDE.drawUploadedImage,
                    title: 'Upload Image',
                }, '|',
                {
                    name: 'undo',
                    action: EasyMDE.undo,
                }, {
                    name: 'redo',
                    action: EasyMDE.redo,
                },

            ],
            imageUploadFunction: async (file, onSuccess, onError) => {
                @this.upload('attachments', file, (url) => {
                    @this.completeUpload(url).then((url) => {
                        onSuccess(url);
                    });
                });
            },
        });

        editor.codemirror.on('change', function() {
            @this.set('message', editor.value(), false);
        });

        // Listen for event called saved
        $wire.on('saved', () => {
            editor.clearAutosavedValue();
            editor.value('');
        });
    </script>
@endscript
