
<section class="customizer-section">

    <div class="customizer-title">Form controls</div>


    <div>
        <h2>Checkboxes</h2>
        <div class="form-control" style="width: 150px;">
            <label class="label cursor-pointer">
                <span class="label-text">Remember me</span>
                <input type="checkbox" checked="checked" class="checkbox" />
            </label>
        </div>

        <div class="form-control" style="width: 150px;">
            <label class="label cursor-pointer">
                <span class="label-text">Remember me</span>
                <input type="checkbox" checked="checked" class="checkbox checkbox-primary" />
            </label>
        </div>

    </div>

    <div>
        <h2>Ranges</h2>
        <input type="range" min="0" max="100" value="40" class="range range-primary" />
        <input type="range" min="0" max="100" value="40" class="range range-accent" />
        <input type="range" min="0" max="100" value="40" class="range range-success" />
        <input type="range" min="0" max="100" value="40" class="range range-warning" />
        <input type="range" min="0" max="100" value="40" class="range range-info" />
        <input type="range" min="0" max="100" value="40" class="range range-error" />

        <input type="range" min="0" max="100" value="25" class="range" step="25" />
        <div class="flex w-full justify-between px-2 text-xs">
          <span>|</span>
          <span>|</span>
          <span>|</span>
          <span>|</span>
          <span>|</span>
        </div>
    </div>

    <div>
        <h2>Rating</h2>

        <div class="rating">
            <input type="radio" name="rating-2" class="mask mask-star-2 bg-orange-400" />
            <input
              type="radio"
              name="rating-2"
              class="mask mask-star-2 bg-orange-400"
              checked="checked" />
            <input type="radio" name="rating-2" class="mask mask-star-2 bg-orange-400" />
            <input type="radio" name="rating-2" class="mask mask-star-2 bg-orange-400" />
            <input type="radio" name="rating-2" class="mask mask-star-2 bg-orange-400" />
        </div>

    </div>



    <div>
        <h2>Inputs</h2>


        <textarea class="textarea textarea-primary" style="width: 100%">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, alias, amet aspernatur atque autem blanditiis consequatur corporis cumque delectus doloremque doloribus ea eius eligendi eos error est eum ex explicabo facilis fugiat harum id illum impedit in ipsa ipsum iusto laborum laudantium magnam maxime minima molestias natus nemo neque nihil nisi nobis non nulla numquam obcaecati odit officiis omnis optio pariatur perferendis perspiciatis placeat praesentium provident quae quam quas quia quidem quisquam quo ratione recusandae rem repellendus repudiandae rerum saepe sapiente sequi similique sit soluta sunt suscipit tempora tenetur totam ullam unde vel veniam veritatis voluptas voluptates voluptatum.
        </textarea>

        <div>
          <input
              type="text"
              placeholder="Type here"
              class="input input-bordered input-primary w-full"
            />
        </div>

        <label class="input input-bordered flex items-center gap-2  input input-bordered input-primary w-full max-w-xs">
            <input type="text" class="grow" placeholder="Search" />
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 16 16"
              fill="currentColor"
              class="h-4 w-4 opacity-70">
              <path
                fill-rule="evenodd"
                d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                clip-rule="evenodd" />
            </svg>
          </label>
          <label class="input input-bordered flex items-center gap-2">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 16 16"
              fill="currentColor"
              class="h-4 w-4 opacity-70">
              <path
                d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z" />
              <path
                d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z" />
            </svg>
            <input type="text" class="grow" placeholder="Email" />
          </label>
          <label class="input input-bordered flex items-center gap-2">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 16 16"
              fill="currentColor"
              class="h-4 w-4 opacity-70">
              <path
                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" />
            </svg>
            <input type="text" class="grow" placeholder="Username" />
          </label>


          <label class="input input-bordered flex items-center gap-2">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 16 16"
              fill="currentColor"
              class="h-4 w-4 opacity-70">
              <path
                fill-rule="evenodd"
                d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                clip-rule="evenodd" />
            </svg>
            <input type="password" class="grow" value="password" />
          </label>


          <label class="form-control w-full max-w-xs">
            <div class="label">
              <span class="label-text">What is your name?</span>
              <span class="label-text-alt">Top Right label</span>
            </div>
            <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
            <div class="label">
              <span class="label-text-alt">Bottom Left label</span>
              <span class="label-text-alt">Bottom Right label</span>
            </div>
          </label>


    </div>
</section>
