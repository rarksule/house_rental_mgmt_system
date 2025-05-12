
<footer class="bg-dark text-white py-4 mt-5" id="about">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h4>{{__("message.About_Us")}}</h4>
                    <p>{{__("message.about_descr")}}</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h4>{{__("message.Contact_Us")}}</h4>
                    <p>{{__("message.university")}}</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <p>{{__("message.moreInfo")}}</p>
                    <a class="mb-3 d-block" href="{{ route('privacy') }}">{{__("message.privacy")}}</a>
                    <a class="mb-3 d-block" href="{{ route('cookie') }}">{{__("message.cookie")}}</a>
                    <a class="mb-3 d-block" href="{{ route('terms') }}">{{__("message.term_cond")}}</a>
                </div>
            </div>
            <hr class="my-4">
            
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">©2025 All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <button class="btn btn-outline-light"><i class="fas fa-arrow-up"><a href="#">{{__("message.go_up")}}</a></i></button>
                </div>
            </div>
        </div>
    </footer>