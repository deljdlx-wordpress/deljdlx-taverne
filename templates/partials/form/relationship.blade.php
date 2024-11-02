@php
use Deljdlx\WPForge\Models\Post;
/*
Parameters
$type    cpt name
$name    field name
$values    list of ids
*/


if(!isset($values)) {
    $values = [];
}

$options = [
    'post_type' => $type,
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
    'post_status' => 'any',
];

$posts = get_posts($options);

$instances = [];

foreach($posts as $post) {
    $instance = new Post();
    $instance->loadFromWpPost($post);
    $instances[] = $instance;
}

@endphp

<div class="custom-field custom-field--relationship">
    <div class="panel">
        <select class="relationship" name="{{$name}}" multiple="multiple">
            @foreach($instances as $instance)
                <option
                    {{array_search($instance->getId(), $values) !== false ? 'selected' : ''}}
                    value="{{$instance->getId()}}"
                >
                    {{$instance->getTitle()}}
                </option>
            @endforeach
        </select>
    </div>
</div>