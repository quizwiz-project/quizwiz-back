<?php

namespace App\Nova;

use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
	public static string $model = \App\Models\User::class;

	public static $title = 'name';

	public static $search = [
		'id', 'name', 'email',
	];

	public function fields(NovaRequest $request): array
	{
		return [
			ID::make()->sortable(),

			Text::make('Name')
				->sortable()
				->rules('required', 'max:255'),

			Text::make('Email')
				->sortable()
				->rules('required', 'email', 'max:254')
				->creationRules('unique:users,email')
				->updateRules('unique:users,email,{{resourceId}}'),

			Image::make('Image')
				->path('images'),

			Password::make('Password')
				->onlyOnForms()
				->creationRules('required', Rules\Password::defaults())
				->updateRules('nullable', Rules\Password::defaults()),

			BelongsToMany::make('Quizzes Completed', 'quizzes', Quiz::class)
				->fields(function () {
					return [
						Number::make('Score')
							->rules('required'),
						Number::make('Time Taken Seconds')
							->rules('required'),
					];
				}),
		];
	}
}
