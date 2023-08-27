<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.6.2/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body class="w-full min-h-screen justify-center items-center flex">

    <form id="saveForm" class="flex flex-col w-full max-w-[500px] p-5">
        <input type="text" name="fullname" placeholder="Fullname" class="input input-bordered mt-2">
        <p class="text-[14px] text-red-500" id="errorFullname"></p>
        <input type="text" name="contactNumber" placeholder="Contact Number" class="input input-bordered mt-2">
        <p class="text-[14px] text-red-500" id="errorContactNumber"></p>
        <input type="text" name="email" placeholder="Email" class="input input-bordered mt-2">
        <p class="text-[14px] text-red-500" id="errorEmail"></p>
        <button type="submit" class="btn btn-success btn-active mt-2" id="save">Save</button>
    </form>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $("#save").click(function (e) { 
                e.preventDefault();
                // get the inputs
                var fullname = $("input[name=fullname]").val();
                var contactNumber = $("input[name=contactNumber]").val();
                var email = $("input[name=email]").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('save') }}",
                    data: {fullname:fullname, contactNumber:contactNumber, email:email},
                    success: function (response) {
                        // reset the value of error messages display
                        $("#errorFullname").html("");
                        $("#errorContactNumber").html("");
                        $("#errorEmail").html("");

                        if(response.status == 200) {
                            // reset value of inputs
                            $("input[name=fullname]").val("");
                            $("input[name=contactNumber]").val("");
                            $("input[name=email]").val("");
                            Toastify({
                                text: "Successfully added a user",
                                className: "info",
                                style: {
                                    background: "#22c55e",
                                }
                            }).showToast();
                        } else {
                            Toastify({
                                text: "Failed to add a user",
                                className: "info",
                                style: {
                                    background: "#ef4444",
                                }
                            }).showToast();
                            // display error messages
                            $("#errorFullname").html(response.errors.fullname);
                            $("#errorContactNumber").html(response.errors.contactNumber);
                            $("#errorEmail").html(response.errors.email);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>