@extends('frontend.layouts.app')
@section('page-style')
    <style>
        .image-container {
            position: relative;
            display: inline-block;
        }

        .image-container img {
            display: block;
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .upload-btn {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            transition: 0.3s;
            z-index: 99;
        }

        .upload-btn:hover {
            background: rgba(0, 0, 0, 0.9);
        }

        .upload-btn input {
            display: none;
        }

        .sec_1_prev_3 {
            width: 270px;
            height: 617px !important;
        }

        .sec_1_prev_2 {
            width: 240px;
            height: 347px
        }

        .sec_1_prev_1 {
            width: 240px;
            height: 240px
        }

        .sec_2_prev_1 {
            width: 338px;
            height: 449px;
        }

        .sec_2_prev_2 {
            width: 276px;
            height: 463px;
        }

        @media screen and (max-width: 480px) {
            .sec_1_prev_3 {
                height: 324px !important;
            }

            .sec_1_prev_2 {
                height: 195px;
            }

            .sec_1_prev_1 {
                height: 190px;
            }

            .sec_2_prev_1 {
                height: 346px;
            }

            .sec_2_prev_2 {
                height: 346px;
            }


        }
    </style>
@endsection
@section('content')
    <section class="page-header">
        <div class="page-header__bg"
            style="background-image: url('{{ asset('frontend') }}/assets/images/backgrounds/page-header-bg-1-1.png');">
        </div><!-- /.page-header__bg -->
        <div class="container">
            <h2 class="page-header__title">About us</h2>
            <ul class="floens-breadcrumb list-unstyled">
                <li><i class="icon-home"></i> <a href="/">Home</a></li>
                <li><span>About us</span></li>
            </ul><!-- /.thm-breadcrumb list-unstyled -->
        </div><!-- /.container -->
    </section><!-- /.page-header -->

    @include('admin.page-settings.about.partials.section_one')
@endsection
@section('page-script')
    <script>
        function setupImagePreview(inputSelector, previewSelector, minWidth, minHeight) {
            $(inputSelector).click();

            $(inputSelector).change(function() {
                if (this.files && this.files[0]) {
                    var file = this.files[0];

                    validateImageSize(file, minWidth, minHeight, function(isValid, imageUrl) {
                        if (isValid) {
                            $(previewSelector).attr("src", imageUrl);
                        }
                    });
                }
            });
        }

        function validateImageSize(file, minWidth, minHeight, callback) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var image = new Image();
                image.src = e.target.result;
                image.onload = function() {
                    if (image.width < minWidth || image.height < minHeight) {
                        alert(`Image is too small! Minimum required size is ${minWidth} × ${minHeight} px.`);
                        callback(false); // Image size is invalid
                    } else {
                        callback(true, e.target.result); // Image is valid
                    }
                };
            };
            reader.readAsDataURL(file);
        }
    </script>

    <script>
        $(document).ready(function() {
            $('[contenteditable="true"]').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    document.execCommand('insertHTML', false, '<br><br>');
                    return false; // Prevents default Enter behavior (which creates <div>)
                }
            });

            $('[contenteditable="true"]').on('paste', function(e) {
                e.preventDefault(); // Stop default paste behavior
                let text = (e.originalEvent || e).clipboardData.getData('text/plain'); // Get plain text
                text = text.replace(/\n/g, '<br>'); // Convert new lines to <br>
                document.execCommand("insertHTML", false, text);
            });

            $('[contenteditable="true"]').on('blur', function() {
                $(this).addClass('edited');
            });
        });


        function saveChanges(cloneId, appendId, formId, buttonId) {
            let fullContent = $(cloneId).clone();

            // Fix line breaks inside contenteditable
            fullContent.find('[contenteditable="true"]').each(function() {
                let content = $(this).html()
                    .replace(/<div>/g, '<br>') // Convert <div> to <br> for new lines
                    .replace(/<\/div>/g, '') // Remove unnecessary closing div tags
                    .replace(/<p>/g, '') // Remove <p> tags if needed
                    .replace(/<\/p>/g, '') // Remove </p> tags if needed
                    .replace(/<br><br>/g, '<br>'); // Prevent double <br>
                $(this).html(content);
            });

            $(appendId).val(fullContent.html());

            // Prepare form data
            let formData = new FormData($(formId)[0]);
            let actionUrl = $(formId).attr('action');

            $.ajax({
                url: actionUrl,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                beforeSend: function() {
                    $(buttonId).prop('disabled', true);
                    $(buttonId).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving.....'
                    )
                },
                success: function(response) {
                    if (response.status === "success") {
                        notify(response.status, response.message);
                    }
                },
                error: function(xhr) {
                    notify('error', 'Failed to save changes.');
                },
                complete: function() {
                    $(buttonId).prop('disabled', false);
                    $(buttonId).html('Save Changes');
                }
            });
        }
    </script>
@endsection
