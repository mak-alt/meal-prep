<div class="popup_wrpr mobile-full" id="discard-meal-creation">
    <div class="popup_wrpr_inner">
        <div class="popup popup_style2 popup_style3">
            <a href="" class="close_popup_btn" data-action="close-popup">
                <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
            </a>
            <div class="popup-delete-entry__content">
                <div class="popup-delete-entry__img flex justify-center">
                    <img src="{{ asset('assets/frontend/img/delete-entry-icon.svg') }}" alt="Delete icon">
                </div>
                <div class="popup-delete-entry__title mt-16">
                    Delete the {{--<span data-field="name"></span>--}} entree meal?
                </div>
                <p class="popup-delete-entry__description">
                    Are you sure you want to delete the entree meal? This will also delete all the sides and you’ll have
                    to start all over again.
                </p>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item">
                    <a href="" class="btn btn_transparent" data-action="close-popup">No, cancel</a>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn_red" data-action="submit-confirmation-popup"
                            data-listener="{{ route('frontend.order-and-menu.meal-creation.discard', $mealNumber) }}"
                            data-request-type="POST">
                        Yes, delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
