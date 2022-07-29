<x-layout>
    <div class="wrapper">
        <section class="question">
            <div class="question__wrapper">
                <div class="question__content">
                    <h2 class="question__header">{{ $blog->name }}</h2>
                    <div class="question__banner-wrapper">
                        @if ($photo = $blog->getFirstMedia('photo'))
                            <img class="question__banner" src="{{ thumb($photo, 'fit', 800) }}" alt="">
                        @endif
                    </div>
                    <h3 class="question__date">{{ date('M d, Y', $blog->from_date) }}</h3>
                    <div>
                        {!! $blog->description !!}
                    </div>
                </div>

                @include('blog.categories', ['theme' => 'm-secondary'])
            </div>
        </section>
        <livewire:comments :entity="$blog"/>
    </div>
</x-layout>
