<div>
    <form action="{{route('support.store')}}" method="post">
        @csrf
        <div class="row mb-4">
            <div class="col">
                <label class="font-600 required" for="email">{{ __('user.email') }}</label>
                <input type="text" name="email" id="email" class="form-control">
            </div>
            <div class="col">
                <label class="font-600 required" for="name">{{ __('user.full name') }}</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <label class="font-600" for="phone">{{ __('user.phone') }}</label>
                <input type="text" name="phone" id="phone" class="form-control">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <label class="font-600 required" for="subject">{{ __('main.subject') }}</label>
                <input type="text" name="subject" id="subject" class="form-control">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col">
                <label class="font-600 required" for="message">{{ __('chat.message') }}</label>
                <textarea name="body" id="message" class="form-control"></textarea>
            </div>
        </div>
        <!-- RECAPTCHA -->
        <div class="mb-4">
            <div id="recaptcha"></div>
        </div>
        <div class="row">
            <div class="col">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg">{{ __('main.send') }}</button>
                </div>
            </div>
        </div>
    </form>

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
                async defer>
    </script>
    <script type="text/javascript">
        var onloadCallback = function () {
            grecaptcha.render('recaptcha', {
                'sitekey': "{{ config('services.recaptcha.key') }}"
            });
        };
    </script>
</div>