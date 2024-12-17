import {
    AccessibilityHelp,
    Autosave,
    SelectAll,
    Undo,
    CodeBlock,
    Strikethrough,
    SourceEditing,
    Alignment,
    Font,
    Clipboard,
    ClassicEditor,
    Autoformat,
    Bold,
    Italic,
    Underline,
    BlockQuote,
    Base64UploadAdapter,
    CloudServices,
    CKBox,
    Essentials,
    Heading,
    Image,
    ImageCaption,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    PictureEditing,
    Indent,
    IndentBlock,
    Link,
    List,
    MediaEmbed,
    Mention,
    Paragraph,
    PasteFromOffice,
    Table,
    TableColumnResize,
    TableToolbar,
    TableCellProperties,
    TableProperties,
    TextTransformation,
} from 'ckeditor5';

$('textarea').each(function() {
    ClassicEditor.create(this, {
        plugins: [
            AccessibilityHelp,
            Autosave,
            SelectAll,
            Undo,
            CodeBlock,
            Strikethrough,
            SourceEditing,
            Alignment,
            Font,
            Clipboard,
            ClassicEditor,
            Autoformat,
            Bold,
            Italic,
            Underline,
            BlockQuote,
            Base64UploadAdapter,
            CloudServices,
            CKBox,
            Essentials,
            Heading,
            Image,
            ImageCaption,
            ImageResize,
            ImageStyle,
            ImageToolbar,
            ImageUpload,
            PictureEditing,
            Indent,
            IndentBlock,
            Link,
            List,
            MediaEmbed,
            Mention,
            Paragraph,
            PasteFromOffice,
            Table,
            TableColumnResize,
            TableToolbar,
            TableProperties,
            TableCellProperties,
            TextTransformation,
        ],
        height: '200px',
        toolbar: [
            'undo',
            'redo',
            '|',
            'heading', 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor',
            '|',
            'bold',
            'italic',
            'underline',
            '|',
            'alignment:left', 'alignment:center', 'alignment:right', 'alignment:justify', '|',
            '|',
            'link',
            'uploadImage',
            'insertTable',
            'blockQuote',
            'mediaEmbed',
            '|',
            'bulletedList',
            'numberedList',
            '|',
            'outdent',
            'indent',
            '|',
            'codeBlock', 'sourceEditing',
        ],
        heading: {
            options: [
                {
                    model: 'paragraph',
                    title: 'Paragraph',
                    class: 'ck-heading_paragraph',
                },
                {
                    model: 'heading1',
                    view: 'h1',
                    title: 'Heading 1',
                    class: 'ck-heading_heading1',
                },
                {
                    model: 'heading2',
                    view: 'h2',
                    title: 'Heading 2',
                    class: 'ck-heading_heading2',
                },
                {
                    model: 'heading3',
                    view: 'h3',
                    title: 'Heading 3',
                    class: 'ck-heading_heading3',
                },
                {
                    model: 'heading4',
                    view: 'h4',
                    title: 'Heading 4',
                    class: 'ck-heading_heading4',
                },
            ],
        },
        image: {
            resizeUnit: 'px',
            toolbar: [
                'imageStyle:inline',
                'imageStyle:wrapText',
                'imageStyle:breakText',
                '|',
                'resizeImage',
                'toggleImageCaption',
                'imageTextAlternative'
            ],
            styles: [
                'inline',
                'wrapText',
                'breakText'
            ]
        },
        link: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://',
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties'],
        },
        clipboard: {
            pasteFromOffice: true
        },
        fontSize: {
            options: [
                8,9,10,11,12,14,16, 18, 20,22,24,26,28,32,36,48,72
            ]
        },
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true
            }
        }
    })
    .then((editor) => {
        window.editor = editor;
    })
    .catch((error) => {
        console.error(error.stack);
    });
})