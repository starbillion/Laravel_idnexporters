<?php
$numItems = count($plans);
$i        = 0;
?>
<div class="block block-bordered">
    <div class="block-header bg-gd-pulse">
        <h3 class="block-title text-white"><i class="si si-badge"></i>&nbsp; {{ __('general.account_upgrade') }}</h3>
    </div>
    <div class="block-content block-content-full">
        <p>{{ __('general.account_upgrade_description') }}</p>

        <div id="plan" data-children=".chi">
            @foreach($plans as $key => $plan)
            <div class="chi pt-10 pb-10 {{ (++$i === $numItems) ? '' : 'border-b' }}">
                <a data-toggle="collapse" data-parent="#plan" href="#plan-{{ $plan->name }}" aria-expanded="true" aria-controls="plan-{{ $plan->name }}">
                    <span class="font-w600">
                        {{ __('package.' . $plan->type .'.'. $plan->name . '.name') }}
                    </span>

                    {{ __('package.' . $plan->type .'.'. $plan->name . '.description') }}
                </a>
                <div id="plan-{{ $plan->name }}" class="collapse" role="tabpanel">
                    <ul class="pl-20 mt-10">
                    @foreach($plan->features()->orderBy('sort_order')->get() as $feature)
                        @if($plan->name == 'option_3')
                        @if($feature->code == 'traffic')
                            @if($plan->name == 'option_3')
                            <li>
                                {{ __('package.' . $plan->type .'.'. $plan->name . '.features.fee') }}
                            </li>
                            @else
                            <li class="{{ !$feature->value ? 'text-muted' : '' }}">
                                {{ __('package.' . $plan->type .'.'. $plan->name . '.features.'.$feature->code) }}
                            </li>
                            @endif
                        @elseif($feature->code == 'exhibition_directories')
                            @if($plan->name == 'option_3')
                            @else
                            <li class="{{ !$feature->value ? 'text-muted' : '' }}">
                                {{ __('package.' . $plan->type .'.'. $plan->name . '.features.'.$feature->code) }}
                            </li>
                            @endif
                        @elseif($feature->code == 'discounts' and $plan->name != 'regular')
                        <li>
                            <a class="text-danger" href="#" data-toggle="modal" data-target="#sponsored_exhibitions">
                                {{ __('package.' . $plan->type .'.'. $plan->name . '.features.'.$feature->code) }}
                            </a>
                        </li>
                        @endif
                        @else
                        @if($feature->code == 'products')
                        <li>
                            {{ __('package.' . $plan->type .'.'. $plan->name . '.features.products') }}
                        </li>
                        @elseif($feature->code == 'discounts' and $plan->name != 'regular')
                        <li>
                            <a class="text-danger" href="#" data-toggle="modal" data-target="#sponsored_exhibitions">
                                {{ __('package.' . $plan->type .'.'. $plan->name . '.features.'.$feature->code) }}
                            </a>
                        </li>
                        @elseif($feature->code == 'company_logo' and $plan->name != 'regular')
                        <li>
                            <a class="text-danger" href="#" data-toggle="modal" data-target="#package-logo">
                                {{ __('package.' . $plan->type .'.'. $plan->name . '.features.'.$feature->code) }}
                            </a>
                        </li>
                        @elseif($feature->code == 'company_banners' and $plan->name != 'regular')
                        <li>
                            <a class="text-danger" href="#" data-toggle="modal" data-target="#package-banners">
                                {{ __('package.' . $plan->type .'.'. $plan->name . '.features.'.$feature->code) }}
                            </a>
                        </li>
                        @else
                        <li class="{{ !$feature->value ? 'text-muted' : '' }}">
                            {{ __('package.' . $plan->type .'.'. $plan->name . '.features.'.$feature->code) }}
                        </li>
                        @endif
                        @endif
                    @endforeach
                    </ul>

                    @if(userPackage()->id == $plan->id)
                        <span class="btn btn-hero btn-sm btn-block btn-secondary">{{ __('general.current_account') }}</span>
                    @else
                        @if($requested)
                            @if($requested->plan_id == $plan->id)
                                <button class="btn btn-hero btn-sm btn-block btn-primary" disabled>{{ __('package.requested') }}</button>
                            @else
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#package-process">
                                    <span class="btn btn-hero btn-sm btn-block btn-danger">{{ __('general.apply') }}</span>
                                </a>
                            @endif
                        @else
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#package-{{ $plan->id }}-request">
                            <span class="btn btn-hero btn-sm btn-block btn-danger">{{ __('general.apply') }} {{ __('package.' . $plan->type .'.'. $plan->name . '.name') }}</span>
                        </a>
                        @endif
                    @endif
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

<div class="modal fade" id="package-logo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img src="{{ asset('img/packages/logo.jpg') }}" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="package-banners" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <img src="{{ asset('img/packages/banners.jpg') }}" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@widget('SponsoredExhibitions')
@widget('ChangePackage')
