<script type="text/javascript">
    function changeProvinceDrop(provinceID) {
        $.ajax({
            type: "get",
            url: "{{ route('get-regions') }}",
            data: {
                id: provinceID,
                postId: $('#hidden_post_id').val(),
                requestFrom: 'post'
            },
            success: function(response) {
                if (response && response != "" && response != null) {
                    if (response !==
                        '<option selected disabled>Select Region</option>') {
                        $(".create-regions").removeClass("d-none");
                        $(".create-regions select option").remove();
                        $('.create-regions select').append(response);
                        changeRegionDrop($('#create-regions option:selected').val(), 'yes');
                    } else {
                        $(".create-regions").addClass("d-none");
                    }
                }
            }
        });
    }

    function changeRegionDrop(regionID) {
        $.ajax({
            type: "get",
            url: "{{ route('get-cities') }}",
            data: {
                id: regionID,
                postId: $('#hidden_post_id').val(),
                requestFrom: 'post'
            },
            success: function(response) {
                if (response && response != "" && response != null) {
                    if (response !==
                        '<option selected disabled>Select City</option>') {
                        $(".create-cities").removeClass("d-none");
                        $(".create-cities select option").remove();
                        $('.create-cities select').append(response);
                        changeCityDrop($('#create-cities option:selected').val(), 'yes');
                    } else {
                        $(".create-cities").addClass("d-none");
                    }
                }
            }
        });
    }

    function changeCityDrop(cityID) {
        $.ajax({
            type: "get",
            url: "{{ route('get-neighbours') }}",
            data: {
                id: cityID,
                postId: $('#hidden_post_id').val(),
                requestFrom: 'post'
            },
            success: function(response) {
                if (response && response != "" && response != null) {
                    if (response !==
                        '<option selected disabled>Select Neighbour</option>') {
                        $(".create-neighbours").removeClass("d-none");
                        $(".create-neighbours select option").remove();
                        $('.create-neighbours select').append(response);
                        // $('#create-neighbours option:selected').val(null);
                    } else {
                        $(".create-neighbours").addClass("d-none");
                    }
                }
            }
        });
    }

    $(document).ready(function() {

        $.ajax({
            type: "get",
            url: "{{ route('get-provinces') }}",
            data: {
                postId: $('#hidden_post_id').val(),
            },
            success: function(response) {
                if (response && response != "" && response != null) {
                    if (response !==
                        '<option selected disabled>Select Provinces / State</option>') {
                        $(".create-province").removeClass("d-none");
                        $(".create-province select option").remove();
                        $('.create-province select').append(response);
                        changeProvinceDrop($('#create-provinces option:selected').val(), 'yes');
                    } else {
                        $(".create-province").addClass("d-none");
                    }
                }
            }
        });
    });

    $(document).on('change', '.countries', function(e) {
        $(".create-province").addClass("d-none");
        $(".create-regions").addClass("d-none");
        $(".create-cities").addClass("d-none");
        $(".create-neighbours").addClass("d-none");
    });
    $(document).on('change', '#create-provinces', function(e) {
        $(".create-regions select").find('option').not(':first').remove();
        $(".create-cities").addClass("d-none");
        $(".create-neighbours").addClass("d-none");
        changeProvinceDrop($('option:selected', this).val());
    });
    $(document).on('change', '#create-regions', function(e) {
        $(".create-cities select").find('option').not(':first').remove();
        $(".create-cities").removeClass("d-none");
        $(".create-neighbours").addClass("d-none");
        changeRegionDrop($('option:selected', this).val());
    });
    $(document).on('change', '#create-cities', function(e) {
        $(".create-neighbours select").find('option').not(':first').remove();
        $(".create-neighbours").removeClass("d-none");
        changeCityDrop($('option:selected', this).val());
    });

    function SearchLocation(code = null, provinceId = null, regionId = null, cityId = null, neighbourId =
        null) {
        var countryValue = null;
        if (!code) {
            countryValue = $('#country').val();
        } else {
            countryValue = code;
        }
        var provinceValue = null;
        if (!provinceId) {
            provinceValue = $('#province').val();
        } else {
            provinceValue = provinceId;
        }
        var regionValue = null;
        if (!regionId) {
            regionValue = $('#regions').val();
        } else {
            regionValue = regionId;
        }
        var cityValue = null;
        if (!cityId) {
            cityValue = $('#cities').val();
        } else {
            cityValue = cityId;
        }
        var neighbourValue = null;
        if (!neighbourId) {
            neighbourValue = $('#neighbours').val();
        } else {
            neighbourValue = neighbourId;
        }
        var data = {
            country: countryValue,
            province: provinceValue,
            region: regionValue,
            city: cityValue,
            neighbour: neighbourValue
        };

        var searchPageURL = $('.searchPageURL').val();

        $.ajax({
            type: "get",
            url: "{{ url('save-location') }}",
            data: data,
            success: function(response) {
                if (countryValue != "{{ session('country.code') }}") {
                    if (searchPageURL == 'posts.index') {
                        window.location.href = "{{ url('') }}/" + countryValue + "/search";
                    } else {
                        window.location.href = "{{ url('/locale/en?country=') }}" + countryValue;
                    }
                } else {
                    window.location.reload();
                }
            }
        });
    }
    $(document).ready(function() {

        $('#item-reviews').removeClass('active');
        $('#item-details').addClass('active');
        $('#item-reviews-tab').removeClass('active');
        $('#item-details-tab').addClass('active');

        $('#loader').addClass('d-none');
        $('#loader').removeClass('.loader-container');
        $('#img-loader').removeClass('.loader');

        $("#register-country").change(function(e) {
            $.ajax({
                type: "get",
                url: "{{ route('get-provinces') }}",
                data: {
                    code: $(this).val()
                },
                success: function(response) {
                    $(".register-province select option").remove();
                    $(".register-regions").addClass("d-none");
                    $(".register-cities").addClass("d-none");
                    $(".register-neighbours").addClass("d-none");
                    $('.register-province select').append(response);
                }
            });
            $(".register-province").removeClass("d-none");
        });
        $("#register-province").change(function(e) {
            $.ajax({
                type: "get",
                url: "{{ route('get-regions') }}",
                data: {
                    id: $(this).val()
                },
                success: function(response) {
                    $(".register-regions select option").remove();
                    $(".register-cities").addClass("d-none");
                    $(".register-neighbours").addClass("d-none");
                    if (response.trim() !== '<option selected disabled>Select Region</option>') {
                        $(".register-regions select").append(response);
                        $(".register-regions").removeClass("d-none");
                    } else {
                        $(".register-regions").addClass("d-none");
                    }
                }
            });
        });
        $("#register-regions").change(function(e) {
            $.ajax({
                type: "get",
                url: "{{ route('get-cities') }}",
                data: {
                    id: $(this).val()
                },
                success: function(response) {
                    $(".register-cities select option").remove();
                    $(".register-neighbours").addClass("d-none");
                    if (response.trim() !== '<option selected disabled>Select City</option>') {
                        $(".register-cities select").append(response);
                        $(".register-cities").removeClass("d-none");
                    } else {
                        $(".register-cities").addClass("d-none");
                    }
                }
            });
        });
        $("#register-cities").change(function(e) {
            $.ajax({
                type: "get",
                url: "{{ route('get-neighbours') }}",
                data: {
                    id: $(this).val()
                },
                success: function(response) {
                    if (response && response != "" && response != null && response !=
                        '<option value="" >Select Neighbour</option>') {
                        $(".register-neighbours select option").remove();
                        $('.register-neighbours select').append(response);
                        $(".register-neighbours").removeClass("d-none");
                    } else {
                        $(".register-neighbours").addClass("d-none");
                    }
                }
            });
        });

        $(".country").change(function(e) {
            $.ajax({
                type: "get",
                url: "{{ route('get-provinces') }}",
                data: {
                    code: $(this).val(),
                    requestFrom: 'general',
                },
                success: function(response) {
                    if (response && response != "" && response != null) {
                        if (response !==
                            '<option selected disabled>Select Provinces / State</option>') {
                            $(".province select option").remove();
                            $(".regions").addClass("d-none");
                            $(".cities").addClass("d-none");
                            $(".neighbours").addClass("d-none");
                            $(".province select").append(response);
                        } else {
                            $(".province").addClass("d-none");
                        }
                    }
                }
            });
            $(".province").removeClass("d-none");
        });
        $(".province").change(function(e) {
            $.ajax({
                type: "get",
                url: "{{ route('get-regions') }}",
                data: {
                    id: $(this).val(),
                    requestFrom: 'general'
                },
                success: function(response) {
                    if (response && response != "" && response != null) {
                        if (response !==
                            '<option selected disabled>Select Region</option>') {
                            $(".regions select option").remove();
                            $(".cities").addClass("d-none");
                            $(".neighbours").addClass("d-none");
                            $(".regions select").append(response);
                        } else {
                            $(".regions").addClass("d-none");
                        }
                    }
                }
            });
            $(".regions").removeClass("d-none");
        });
        $(".regions").change(function(e) {
            $.ajax({
                type: "get",
                url: "{{ route('get-cities') }}",
                data: {
                    id: $(this).val(),
                    requestFrom: 'general'
                },
                success: function(response) {
                    if (response && response != "" && response != null) {
                        if (response !==
                            '<option selected disabled>Select City</option>') {
                            $(".cities select option").remove();
                            $(".neighbours").addClass("d-none");
                            $(".cities select").append(response);
                        } else {
                            $(".cities").addClass("d-none");
                        }
                    }
                }
            });
            $(".cities").removeClass("d-none");
        });
        $(".cities").change(function(e) {
            $.ajax({
                type: "get",
                url: "{{ route('get-neighbours') }}",
                data: {
                    id: $(this).val(),
                    requestFrom: 'general'
                },
                success: function(response) {
                    if (response && response != "" && response != null) {
                        if (response !==
                            '<option selected disabled>Select Neighbour</option>') {
                            $(".neighbours select option").remove();
                            $(".neighbours select").append(response);
                            $(".neighbours").removeClass("d-none");
                        } else {
                            $(".neighbours").addClass("d-none");
                        }
                    }
                }
            });
        });

        $('.country-select').click(function(e) {
            e.preventDefault();
            var code = $(this).attr('code');
            SearchLocation(code);
        });
        $('.province-select').click(function(e) {
            e.preventDefault();
            var code = "{{ session('country.code') }}";
            var provinceId = $(this).attr('provinceId');
            console.log(provinceId, 'hellow1');
            SearchLocation(code, provinceId);
        });
        $('.region-select').click(function(e) {
            e.preventDefault();
            var code = "{{ session('country.code') }}";
            var provinceId = "{{ session('province.id') }}";
            var regionId = $(this).attr('regionId');
            SearchLocation(code, provinceId, regionId);
        });
        $('.city-select').click(function(e) {
            e.preventDefault();
            var code = "{{ session('country.code') }}";
            var provinceId = "{{ session('province.id') }}";
            var regionId = "{{ session('region.id') }}";
            var cityId = $(this).attr('cityId');
            SearchLocation(code, provinceId, regionId, cityId);
        });
        $('.neighbour-select').click(function(e) {
            e.preventDefault();
            var code = "{{ session('country.code') }}";
            var provinceId = "{{ session('province.id') }}";
            var regionId = "{{ session('region.id') }}";
            var cityId = "{{ session('city.id') }}";
            var neighbourId = $(this).attr('neighbourId');
            SearchLocation(code, provinceId, regionId, cityId, neighbourId);
        });
        $('.search-location-btn').click(function(e) {
            e.preventDefault();
            SearchLocation();
        });

        $('.country').change(function(e) {
            e.preventDefault();
            $('.country-breadcrumb').removeClass('d-none');
            $('.country-breadcrumb b').html($("#country option:selected").text());
            $(".country-breadcrumb select option").remove();
            $(".province-breadcrumb").addClass("d-none");
            $(".regions-breadcrumb").addClass("d-none");
            $(".cities-breadcrumb").addClass("d-none");
            $(".neighbours-breadcrumb").addClass("d-none");
        });
        $('.province').change(function(e) {
            e.preventDefault();
            $('.province-breadcrumb').removeClass('d-none');
            $('.province-breadcrumb b').html($("#province option:selected").text());
            $(".province-breadcrumb select option").remove();
            $(".regions-breadcrumb").addClass("d-none");
            $(".cities-breadcrumb").addClass("d-none");
            $(".neighbours-breadcrumb").addClass("d-none");
        });
        $('.regions').change(function(e) {
            e.preventDefault();
            $('.regions-breadcrumb').removeClass('d-none');
            $('.regions-breadcrumb b').html($("#regions option:selected").text());
            $(".regions-breadcrumb select option").remove();
            $(".cities-breadcrumb").addClass("d-none");
            $(".neighbours-breadcrumb").addClass("d-none");
        });
        $('.cities').change(function(e) {
            e.preventDefault();
            $('.cities-breadcrumb').removeClass('d-none');
            $('.cities-breadcrumb b').html($("#cities option:selected").text());
            $(".cities-breadcrumb select option").remove();
            $(".neighbours-breadcrumb").addClass("d-none");
        });
        $('.neighbours').change(function(e) {
            e.preventDefault();
            $('.neighbours-breadcrumb').removeClass('d-none');
            $('.neighbours-breadcrumb b').html($("#neighbours option:selected").text());
        });

        $('.country').change(function(e) {
            e.preventDefault();
            $('.country-breadcrumb').removeClass('d-none');
            $('.country-breadcrumb .breadcrumb-input').html($(".country option:selected").text());
            $(".country-breadcrumb select option").remove();
            $(".province-breadcrumb").addClass("d-none");
            $(".regions-breadcrumb").addClass("d-none");
            $(".cities-breadcrumb").addClass("d-none");
            $(".neighbours-breadcrumb").addClass("d-none");
        });
        $('.province').change(function(e) {
            e.preventDefault();
            $('.province-breadcrumb').removeClass('d-none');
            $('.province-breadcrumb .breadcrumb-input').html($(".province option:selected").text());
            $(".province-breadcrumb select option").remove();
            $(".regions-breadcrumb").addClass("d-none");
            $(".cities-breadcrumb").addClass("d-none");
            $(".neighbours-breadcrumb").addClass("d-none");
        });
        $('.regions').change(function(e) {
            e.preventDefault();
            $('.regions-breadcrumb').removeClass('d-none');
            $('.regions-breadcrumb .breadcrumb-input').html($(".regions option:selected").text());
            $(".regions-breadcrumb select option").remove();
            $(".cities-breadcrumb").addClass("d-none");
            $(".neighbours-breadcrumb").addClass("d-none");
        });
        $('.cities').change(function(e) {
            e.preventDefault();
            $('.cities-breadcrumb').removeClass('d-none');
            $('.cities-breadcrumb .breadcrumb-input').html($(".cities option:selected").text());
            $(".cities-breadcrumb select option").remove();
            $(".neighbours-breadcrumb").addClass("d-none");
        });
        $('.neighbours').change(function(e) {
            e.preventDefault();
            $('.neighbours-breadcrumb').removeClass('d-none');
            $('.neighbours-breadcrumb .breadcrumb-input').html($(".neighbours option:selected")
                .text());
        });

        $('#printer').click(function(e) {
            e.preventDefault();
            window.print();
        });

        var currentPath = window.location.pathname;
        
        if (localStorage.getItem("mode") == "light") {
            setLightMode();
        } else {
            setDarkMode();
        }

        $(".themeMode").click(function () {
            toggleMode();
        });

        function setLightMode() {
            $('.themeModeButton').removeClass('btn-light').addClass('btn-dark').html('<i class="fa fa-sun"></i> High contrast mode');
            $('body').addClass('light').removeClass('dark');
        }

        function setDarkMode() {
            $('.themeModeButton').removeClass('btn-dark').addClass('btn-light').html('<i class="fa fa-moon"></i> Light Mode');
            $('body').addClass('dark').removeClass('light');
        }

        function toggleMode() {
            let currentMode = localStorage.getItem("mode");
            let newMode = (currentMode == 'light') ? 'dark' : 'light';

            localStorage.setItem("mode", newMode);
            updateQueryParameter('mode', newMode);
            location.reload();
        }

        function updateQueryParameter(key, value) {
            let url = new URL(window.location.href);
            url.searchParams.set(key, value);
            window.history.replaceState({}, '', url);
        }
        
        $('.item-carousel-thumb source').remove();
        $(window).on('load', function() {
                $.ajax({
                    url: "{{ route('get-categories') }}",
                    type: 'GET',
                    success: function(response) {
                        if (response.all_categories) {
                            if (window.innerWidth > 576) {
                                $('.get-categories').append(response.all_categories);
                            } else {
                                $('.get-categories').append('');
                            }
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
        });
        // $.ajax({
        //     url: "{{ route('get-categories') }}",
        //     type: 'GET',
        //     success: function(response) {
        //         if (response.all_categories) {
        //             if (window.innerWidth > 576) {
        //                 $('.get-categories').append(response.all_categories);
        //             } else {
        //                 $('.get-categories').append('');
        //             }
        //         }
        //         if (response.parentCategoriesHtml) {
        //             $('.banner-image-loader').remove();
        //             $('#get-parent-categories').removeClass('banner-loader-middle');
        //             $('#get-parent-categories').removeClass('categories-loader-middle');
        //             $('#get-parent-categories').append(response.parentCategoriesHtml);
        //         }
        //     },
        //     error: function(xhr) {
        //         console.log(xhr.responseText);
        //     }
        // });

    });
</script>