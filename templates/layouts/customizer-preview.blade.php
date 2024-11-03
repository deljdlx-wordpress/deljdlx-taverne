@extends('layouts/common/default')
@section('page-title')
    Customizer Preview
@endsection

@section('page-content')
    <h1> Customizer preview </h1>


    <section class="customizer-section">
        <div class="customizer-title">Colors</div>
        <div style="display: flex; gap: 1rem">
            <div>
                neutral
                <div style="background-color: oklch(var(--neutral-color)); width: 50px; height: 50px"></div>
            </div>
            <div>
                primary
                <div style="background-color: oklch(var(--primary-color)); width: 50px; height: 50px"></div>
            </div>
            <div>
                secondary
                <div style="background-color: oklch(var(--secondary-color)); width: 50px; height: 50px"></div>
            </div>
            <div>
                accent
                <div style="background-color: oklch(var(--accent-color)); width: 50px; height: 50px"></div>
            </div>
            <div>
                info
                <div style="background-color: oklch(var(--info-color)); width: 50px; height: 50px"></div>
            </div>
            <div>
                success
                <div style="background-color: oklch(var(--success-color)); width: 50px; height: 50px"></div>
            </div>
            <div>
                error
                <div style="background-color: oklch(var(--error-color)); width: 50px; height: 50px"></div>
            </div>

        </div>

    </section>

    <div style="display: flex;">

        <section class="customizer-section">
            <div class="customizer-title">Titles</div>
            <h1>h1 title</h1>
            <h2>h2 title</h2>
            <h3>h3 title</h3>
            <h4>h4 title</h4>
            <h5>h5 title</h5>
            <h6>h6 title</h6>
        </section>

        <section class="customizer-section">
            <div class="customizer-title">Links</div>
            <ul>
                <li><a href="#">Link 1 </a></li>
                <li><a href="#">Link 2 </a></li>
                <li><a href="#">Link 3 </a></li>
            </ul>
        </section>
    </div>


    <section class="customizer-section">
        <h1 class="section-title-1">Cards</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="card">
                <a class="block" href="#">
                    <img class="block" src="https://picsum.photos/200/300" style="width: 100%"/>
                    <div class="card-title">
                        <h1>Title h1</h1>
                    </div>
                </a>
            </div>
            <div class="card">
                <a class="block" href="#">
                    <img class="block" src="https://picsum.photos/200/300" style="width: 100%"/>
                    <div class="card-title">
                        <h2>Title h2</h2>
                    </div>
                </a>
            </div>
            <div class="card">
                <a class="block" href="#">
                    <img class="block" src="https://picsum.photos/200/300" style="width: 100%"/>
                    <div class="card-title">
                        <h2>Title h3</h2>
                    </div>
                </a>
            </div>
            <div class="card">
                <a class="block" href="#">
                    <img class="block" src="https://picsum.photos/200/300" style="width: 100%"/>
                    <div class="card-title">
                        <h2>Title h4</h2>
                    </div>
                </a>
            </div>
        </div>
    </section>




    <section class="customizer-section">
        <div class="customizer-title">Paragraphs</div>
        <div style="
        display: flex;
        gap: 1rem">
            <div>
                <div>before</div>
                <h1>H1 title</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias, amet aspernatur atque autem
                    blanditiis consequatur corporis cumque delectus doloremque doloribus ea eius eligendi eos error est eum
                    ex explicabo facilis fugiat harum id illum impedit in ipsa ipsum iusto laborum laudantium magnam maxime
                    minima molestias natus nemo neque nihil nisi nobis non nulla numquam obcaecati odit officiis omnis optio
                    pariatur perferendis perspiciatis placeat praesentium provident quae quam quas quia quidem quisquam quo
                    ratione recusandae rem repellendus repudiandae rerum saepe sapiente sequi similique sit soluta sunt
                    suscipit tempora tenetur totam ullam unde vel veniam veritatis voluptas voluptates voluptatum.</p>
                <div>after</div>
            </div>

            <div>
                <div>before</div>
                <h2>H2 title</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias, amet aspernatur atque autem
                    blanditiis consequatur corporis cumque delectus doloremque doloribus ea eius eligendi eos error est eum
                    ex explicabo facilis fugiat harum id illum impedit in ipsa ipsum iusto laborum laudantium magnam maxime
                    minima molestias natus nemo neque nihil nisi nobis non nulla numquam obcaecati odit officiis omnis optio
                    pariatur perferendis perspiciatis placeat praesentium provident quae quam quas quia quidem quisquam quo
                    ratione recusandae rem repellendus repudiandae rerum saepe sapiente sequi similique sit soluta sunt
                    suscipit tempora tenetur totam ullam unde vel veniam veritatis voluptas voluptates voluptatum.</p>
                <div>after</div>
            </div>

            <div>
                <div>before</div>
                <h3>H3 title</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias, amet aspernatur atque autem
                    blanditiis consequatur corporis cumque delectus doloremque doloribus ea eius eligendi eos error est eum
                    ex explicabo facilis fugiat harum id illum impedit in ipsa ipsum iusto laborum laudantium magnam maxime
                    minima molestias natus nemo neque nihil nisi nobis non nulla numquam obcaecati odit officiis omnis optio
                    pariatur perferendis perspiciatis placeat praesentium provident quae quam quas quia quidem quisquam quo
                    ratione recusandae rem repellendus repudiandae rerum saepe sapiente sequi similique sit soluta sunt
                    suscipit tempora tenetur totam ullam unde vel veniam veritatis voluptas voluptates voluptatum.</p>
                <div>after</div>
            </div>

            <div>
                <div>before</div>
                <h4>H4 title</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias, amet aspernatur atque autem
                    blanditiis consequatur corporis cumque delectus doloremque doloribus ea eius eligendi eos error est eum
                    ex explicabo facilis fugiat harum id illum impedit in ipsa ipsum iusto laborum laudantium magnam maxime
                    minima molestias natus nemo neque nihil nisi nobis non nulla numquam obcaecati odit officiis omnis optio
                    pariatur perferendis perspiciatis placeat praesentium provident quae quam quas quia quidem quisquam quo
                    ratione recusandae rem repellendus repudiandae rerum saepe sapiente sequi similique sit soluta sunt
                    suscipit tempora tenetur totam ullam unde vel veniam veritatis voluptas voluptates voluptatum.</p>
                <div>after</div>
            </div>
        </div>
    </section>


    <section class="customizer-section">
        <div class="customizer-title">Buttons</div>
        <div>
            <button class="btn">Button</button>
            <button class="btn btn-neutral">Neutral</button>
            <button class="btn btn-primary">Primary</button>
            <button class="btn btn-secondary">Secondary</button>
            <button class="btn btn-accent">Accent</button>
            <button class="btn btn-ghost">Ghost</button>
            <button class="btn btn-link">Link</button>
            <button class="btn btn-info">Info</button>
            <button class="btn btn-success">Success</button>
            <button class="btn btn-warning">Warning</button>
            <button class="btn btn-error">Error</button>
        </div>
    </section>


    <section class="customizer-section">
        <div class="customizer-title">Badges</div>
        <div>
            <div class="badge">default</div>
            <div class="badge badge-neutral">neutral</div>
            <div class="badge badge-primary">primary</div>
            <div class="badge badge-secondary">secondary</div>
            <div class="badge badge-accent">accent</div>
            <div class="badge badge-ghost">ghost</div>
        </div>
    </section>


    @include('partials/customizer-preview/form')
@endsection
