<div class="col-lg-12 block_page">
    <h4>Partners & References</h4>
    <div class="form-group">
        <div class="col-md-12 pl-0 pt-1">
            <input type="text" class="form-control w-100" name="data[first_local_partners][title]"
                   id="first_local_partners" placeholder="Title..."
                   value="{{ old('data.first_local_partners.title', $page->data['first_local_partners']['title']) }}"
                   required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.first_local_partners.title'])
        </div>
        @foreach($page->data['first_local_partners']['items'] as $firstLocalPartner)
            <div class="form-group_inner">
                <div class="col-md-8 p-0 {{ $loop->first ? 'pt-3' : '' }}">
                    <input type="text" class="form-control w-100 input-default"
                           name="data[first_local_partners][items][{{ $loop->index }}][text]"
                           placeholder="Local partners text..."
                           value="{{ old("data.first_local_partners.items.$loop->index.text", $firstLocalPartner['text']) }}"
                           required>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => "data.first_local_partners.items.$loop->index.text"])
                </div>
                <div class="col-md-2 {{ $loop->first ? 'pt-3' : '' }}">
                    <input type="file" class="form-control-file"
                           name="data[first_local_partners][items][{{ $loop->index }}][image]">
                    @include('backend.layouts.partials.alerts.input-error', ['name' => "data.first_local_partners.items.$loop->index.image"])
                </div>
                @if(!empty($firstLocalPartner['image']))
                    <div class="col-md-2 {{ $loop->first ? 'pt-3' : '' }}">
                        <img src="{{ asset($firstLocalPartner['image']) }}" class="img img-md"
                             alt="Local partners image">
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

<div class="col-lg-12 block_page">
    <div class="form-group">
        <div class="col-md-12 pl-0 pt-1">
            <input type="text" class="form-control w-100" name="data[second_local_partners][title]"
                   id="second_local_partners" placeholder="Title..."
                   value="{{ old('data.second_local_partners.title', $page->data['second_local_partners']['title']) }}"
                   required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.second_local_partners.title'])
        </div>
        @foreach($page->data['second_local_partners']['items'] as $secondLocalPartner)
            <div class="form-group_inner">
                <div class="col-md-8 p-0 {{ $loop->first ? 'pt-3' : '' }}">
                    <input type="text" class="form-control w-100 input-default"
                           name="data[second_local_partners][items][{{ $loop->index }}][text]"
                           placeholder="Local partners text..."
                           value="{{ old("data.second_local_partners.items.$loop->index.text", $secondLocalPartner['text']) }}"
                           required>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => "data.second_local_partners.items.$loop->index.text"])
                </div>
                <div class="col-md-2 {{ $loop->first ? 'pt-3' : '' }}">
                    <input type="file" class="form-control-file"
                           name="data[second_local_partners][items][{{ $loop->index }}][image]">
                    @include('backend.layouts.partials.alerts.input-error', ['name' => "data.second_local_partners.items.$loop->index.image"])
                </div>
                @if(!empty($secondLocalPartner['image']))
                    <div class="col-md-2 {{ $loop->first ? 'pt-3' : '' }}">
                        <img src="{{ asset($secondLocalPartner['image']) }}" class="img img-md"
                             alt="Local partners image">
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

<div class="col-lg-12 block_page">
    <div class="form-group">
        <div class="col-md-12 pl-0 pt-1">
            <input type="text" class="form-control w-100" name="data[recipe_adaptation_references][title]"
                   id="recipe_adaptation_references" placeholder="Title..."
                   value="{{ old('data.recipe_adaptation_references.title', $page->data['recipe_adaptation_references']['title']) }}"
                   required>
            @include('backend.layouts.partials.alerts.input-error', ['name' => 'data.recipe_adaptation_references.title'])
        </div>
        @foreach($page->data['recipe_adaptation_references']['items'] as $recipeAdaptationReference)
            <div class="form-group_inner">
                <div class="col-md-8 p-0 {{ $loop->first ? 'pt-3' : '' }}">
                    <input type="text" class="form-control w-100 input-default"
                           name="data[recipe_adaptation_references][items][{{ $loop->index }}][link]"
                           placeholder="Recipe adaptation references link..."
                           value="{{ old("data.recipe_adaptation_references.items.$loop->index.text", $recipeAdaptationReference['link']) }}"
                           required>
                    @include('backend.layouts.partials.alerts.input-error', ['name' => "data.recipe_adaptation_references.items.$loop->index.link"])
                </div>
                <div class="col-md-2 {{ $loop->first ? 'pt-3' : '' }}">
                    <input type="file" class="form-control-file"
                           name="data[recipe_adaptation_references][items][{{ $loop->index }}][link]">
                    @include('backend.layouts.partials.alerts.input-error', ['name' => "data.recipe_adaptation_references.items.$loop->index.link"])
                </div>
                @if(!empty($recipeAdaptationReference['image']))
                    <div class="col-md-2 {{ $loop->first ? 'pt-3' : '' }}">
                        <img src="{{ asset($recipeAdaptationReference['image']) }}" class="img img-md"
                             alt="Recipe adaptation references image">
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
