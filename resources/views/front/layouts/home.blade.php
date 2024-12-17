<!DOCTYPE html>
<html lang="en">
@include('front.partials.head')
@stack('styles')
<body>
<div id="ec-overlay"><span class="loader_img"></span></div>

@include('front.partials.header')

<!-- Ekka Cart Start -->
<div class="ec-side-cart-overlay"></div>

@yield('content')
@include('front.partials.footer')
@include('front.partials.foot')
@stack('scripts')
<script>
    // Function to force landscape mode
    function lockOrientation() {
        if (screen.orientation && screen.orientation.lock) {
            if (screen.width < 750) {
                // Lock orientation to portrait for devices with width less than 750px
                screen.orientation.lock("portrait").catch(function(error) {
                    console.warn("Could not lock orientation: " + error);
                });
            } else {
                // Lock orientation to landscape for devices with width greater than 750px
                screen.orientation.lock("landscape").catch(function(error) {
                    console.warn("Could not lock orientation: " + error);
                });
            }
        } else {
            console.warn("Screen orientation API not supported.");
        }
    }

    $(document).ready(function () {

        })
</script>
</body>
</html>
