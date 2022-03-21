<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Velv - Server Listing - Coding Challenge</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body >
<div id="app">
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Velv</h1>
                <p class="lead fw-normal text-white-50 mb-0">Server comparison challenge.</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row  mb-5 justify-content-center">
                <div class="col-11 align-self-center">
                    <input type="search" class="form-control" v-model="filters.selected.text" placeholder="Search by text">
                </div>
                <div class="col-1 align-self-center text-center">
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#filtersModal">
                        <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <div class="col mb-5" v-for="server in filteredServers">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="{{ asset('img/server.jpg') }}" alt="..." />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">@{{ server.model }}</h5>
                                <!-- Product price-->
                                <ul class="specs">
                                    <li>RAM: @{{ server.ram.amount + server.ram.unity + ' ' + server.ram.type }}</li>
                                    <li>HDD: @{{ server.hdd.amount + server.hdd.unity + ' ' + server.hdd.type }}</li>
                                    <li>@{{ server.location }}</li>
                                </ul>
                                @{{ server.price }}
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto" @click="addToComparison(server)" v-if="!server.compared">Compare</a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Breno Grillo 2022</p></div>
    </footer>

    <!-- Modal -->
    <div class="modal fade" id="filtersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filters</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row filter">
                        <div class="row">
                            <div class="col filter-title">
                                Storage
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <span class="numeric">>= @{{ filters.selected.storage }} GB</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="range" class="form-range" v-model="filters.selected.storage" v-bind:min="filters.options.storage[0]" v-bind:max="filters.options.storage[filters.options.storage.length - 1]" id="customRange2">
                            </div>
                        </div>
                    </div>
                    <div class="row filter">
                        <div class="row">
                            <div class="col filter-title">
                                RAM
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="ram-checkboxes col-4" v-for="(ramOption, index) in filters.options.ram">
                                        <input class="form-check-input" type="checkbox" v-model="filters.selected.ram" v-bind:value="ramOption" v-bind:id="'ramOption' + index">
                                        <label class="form-check-label" v-bind:for="'ramOption' + index">
                                            @{{ ramOption }} GB
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row filter">
                        <div class="row-fluid">
                            <div class="col filter-title">
                                HDD
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="col">
                                <select class="form-control select2" multiple="true" data-select2-property="hdd" v-model="filters.selected.hdd">
                                    <option v-for="hddOption in filters.options.hdd">@{{ hddOption }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row filter">
                        <div class="row-fluid">
                            <div class="col filter-title">
                                Location
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="col">
                                <select class="form-control select2" data-select2-property="location" multiple="true" v-model="filters.selected.location">
                                    <option v-for="locationOptions in filters.options.location">@{{ locationOptions }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="comparisonModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Compare servers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6" v-if="comparison.a">
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" src="{{ asset('img/server.jpg') }}" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder">@{{ comparison.a.model }}</h5>
                                        <!-- Product price-->
                                        <ul class="specs">
                                            <li>RAM: @{{ comparison.a.ram.amount + comparison.a.ram.unity + ' ' + comparison.a.ram.type }}</li>
                                            <li>HDD: @{{ comparison.a.hdd.amount + comparison.a.hdd.unity + ' ' + comparison.a.hdd.type }}</li>
                                            <li>@{{ comparison.a.location }}</li>
                                        </ul>
                                        @{{ comparison.a.price }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6" v-if="comparison.b">
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" src="{{ asset('img/server.jpg') }}" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder">@{{ comparison.b.model }}</h5>
                                        <!-- Product price-->
                                        <ul class="specs">
                                            <li>RAM: @{{ comparison.b.ram.amount + comparison.b.ram.unity + ' ' + comparison.b.ram.type }}</li>
                                            <li>HDD: @{{ comparison.b.hdd.amount + comparison.b.hdd.unity + ' ' + comparison.b.hdd.type }}</li>
                                            <li>@{{ comparison.b.location }}</li>
                                        </ul>
                                        @{{ comparison.b.price }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Jquery -->
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
<!-- Select2 Dropdown -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#filtersModal').on('shown.bs.modal', function() {
            $('#filtersModal .select2').select2({
                dropdownParent: $('#filtersModal')
            });

            $('#filtersModal .select2').change(function() {
                app.$set(app.filters.selected, $(this).data('select2-property'), $(this).val());
            })
        })
    });
</script>
<!-- Core theme JS-->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
