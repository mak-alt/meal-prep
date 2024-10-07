<div class="popup_wrpr popup-success-filter mobile-full" id="filter-by-tags">
    <div class="popup_wrpr_inner">
        <div class="popup">
            <a href="" class="close_popup_btn" data-action="close-popup" data-do-not-reset-form="{{ true }}">
                <img src="{{ asset('assets/frontend/img/close-popup.svg') }}" alt="Close icon">
            </a>
            <div class="filters">
                <div class="filters__title">
                    All filters
                </div>
                <form action="{{ route('frontend.order-and-menu.select-meals', $mealNumber) }}" method="GET">
                    @csrf
                    <input type="hidden" name="filter[tags]" value="{{ null }}">
                    <div class="flex filters-block">
                        <div class="flex flex-col filters-col">
                            @foreach($tags->take(8) as $tag)
                                <label class="standart_checkbox filter-checkbox-item">
                                    <input type="checkbox" name="filter[tags][]" value="{{ $tag->name }}">
                                    <span class="standart_checkbox__check"></span>
                                    <span class="standart_checkbox__label">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        <div class="flex flex-col filters-col">
                            @foreach($tags->skip(8) as $tag)
                                <label class="standart_checkbox filter-checkbox-item">
                                    <input type="checkbox" name="filter[tags][]" value="{{ $tag->name }}">
                                    <span class="standart_checkbox__check"></span>
                                    <span class="standart_checkbox__label">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
            <div class="popup_btn_wrpr">
                <div class="popup_btn_wrpr_item clean-all" style="display: none">
                    <button type="button" class="btn btn_transparent" data-action="unselect-all-filters">
                        Clear all
                    </button>
                </div>
                <div class="popup_btn_wrpr_item select-all">
                    <button type="button" class="btn btn_transparent">
                        Select all
                    </button>
                </div>
                <div class="popup_btn_wrpr_item">
                    <button type="button" class="btn btn-green" data-action="filter" data-items-wrapper-id="meals">
                        Show results
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
