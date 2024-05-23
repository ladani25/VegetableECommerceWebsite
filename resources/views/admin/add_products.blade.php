<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Editor Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        #editor {
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: 10px;
            min-height: 200px;
            margin-top: 10px;
            resize: vertical;
            overflow: auto;
            box-shadow: inset 0 0 10px silver;
        }
        .toolbar {
            margin-bottom: 10px;
            text-align: center;
            padding: 5px;
            margin: 5px;
        }
        .toolbar a {
            margin-right: 5px;
            cursor: pointer;
            color: black;
            padding: 5px;
        }
        .toolbar a:hover {
            text-decoration: none;
        }
        textarea#output {
            display: none;
            width: 99.7%;
            height: 100px;
        }
    </style>
</head>
<body>
    @include('admin.header')

    <div class="page-content" style="padding-bottom: 90px;">
        <div class="block-body" style="padding-top:3%">
            <div class="card mb-4 container">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Add Product</h6>
                </div>
                <div class="card-body container">
                    <form method="POST" enctype="multipart/form-data" action="{{url('get_products')}}">
                        @method('post')
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter product name">
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="images" class="custom-file-input" id="customFile" multiple>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control" placeholder="Enter price">
                        </div>
                        <div class="form-group">
                            <label>Selling Price</label>
                            <input type="number" name="selling_price" class="form-control" placeholder="Enter selling price">
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="quantity" class="form-control" placeholder="Enter quantity">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" name="c_id">
                                @foreach($categeroy as $category)
                                    <option value="{{ $category->c_id }}">{{ $category->c_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <div class="toolbar" id="editControls">
                                <a data-role="undo" href="javascript:void(0)"><i class="fa fa-undo"></i></a>
                                <a data-role="redo" href="javascript:void(0)"><i class="fa fa-repeat"></i></a>
                                <a data-role="bold" href="javascript:void(0)"><i class="fa fa-bold"></i></a>
                                <a data-role="italic" href="javascript:void(0)"><i class="fa fa-italic"></i></a>
                                <a data-role="underline" href="javascript:void(0)"><i class="fa fa-underline"></i></a>
                                <a data-role="strikeThrough" href="javascript:void(0)"><i class="fa fa-strikethrough"></i></a>
                            </div>
                            <div id="editor" contenteditable="true">
                                <h1>This is a title!</h1>
                                <p>This is just some example text to start us off</p>
                            </div>
                            <textarea id="output" name="description"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('admin.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editor = document.getElementById('editor');
            const output = document.getElementById('output');
            const buttons = document.querySelectorAll('.toolbar a');

            // Add event listeners to toolbar buttons to apply formatting
            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const command = this.getAttribute('data-role');
                    document.execCommand(command, false, null);
                });
            });

            // Update the hidden textarea whenever the content of the editor changes
            function updateOutput() {
                output.value = editor.innerHTML;
            }

            editor.addEventListener('input', updateOutput);

            // Update the hidden textarea before the form is submitted
            document.querySelector('form').addEventListener('submit', function (event) {
                updateOutput();
            });
        });
    </script>
</body>
</html>
