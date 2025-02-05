/*
   Template Name: Steex - Admin & Dashboard Template
   Author: Themesbrand
   Website: https://Themesbrand.com/
   Contact: Themesbrand@gmail.com
   File: Learning instructors grid init js
*/

// Instrucor Images
var dropzonePreviewNode = document.querySelector("#instrucor-preview-list");
dropzonePreviewNode.id = "";
if (dropzonePreviewNode) {
    var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
    dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
    var dropzone = new Dropzone(".instrucor-dropzone", {
        url: 'https://httpbin.org/post',
        method: "post",
        previewTemplate: previewTemplate,
        previewsContainer: "#instrucor-preview",
    });
}
