<!doctype html>
<html lang="en">

<head>
    <title>WS GOUCARGO</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    {{-- Favicon --}}
    <link rel="icon" href="favicon-goucargo2.png" type="image/x-icon">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

</head>

<body>


    <section class="pt-5 pb-5 mt-0 align-items-center d-flex bg-dark"
        style="min-height: 100vh; background-size: cover; background-image: url(goucargo-fondo.png);">
        <div class="container-fluid">

            <div class="row  justify-content-center align-items-center d-flex-row  h-100">
                <div class="col-12 col-md-4 col-lg-3   h-50 ">
                    <div class="card shadow">
                        <div class="card-body mx-auto">

                            <img src="goucargo-1.png" class="img-fluid rounded" alt="" />

                            <form class="bg-white p-2 text-dark " action="{{ route('login-store') }}" method="POST">
                                @csrf
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-person-circle"></i></span>
                                    <input type="text" class="form-control" placeholder="Username" name="user"
                                        aria-label="Username" aria-describedby="addon-wrapping">
                                </div>
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="bi bi-incognito"></i></span>
                                    <input type="password" class="form-control" placeholder="Password" name="password"
                                        aria-label="Password" aria-describedby="addon-wrapping">
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Remember me?</label>
                                </div>
                                <button type="submit" class="btn btn-dark w-100">Sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>

</html>
