<h1>Pick a Regione from {{total regions}}</h1>

<div class="search-box">
    <i class="icon-search"></i>
    <input type="text" class="closed search-input" placeholder="Cerca">
</div>

<div class="result-wrapper nano">
    <div class="content">
    {{#each regions}}
        <label class="checkbox">
            <input type="checkbox" name="cats-check" value="{{ this.id }}">
            <span>{{ this.Regione }}</span>
        </label>
    {{/each}}
    </div>
</div>
<div class="control-nav group">
    <a 
        href="#" 
        class="nav-arrow nav-arrow-left"
        data-has-choice="no" 
        data-to="start">
        <i class="icon-chevron-left"></i>
    </a>
    <a 
        href="#" 
        class="nav-arrow nav-arrow-right" 
        data-has-choice="yes">
        <i class="icon-chevron-right"></i>
    </a>

    <div class="nav-btns">
        <a href="#" class="nav-btn" data-to="zones">
            Provincia
        </a>
        <a href="#" class="nav-btn" data-to="personal">
            Submit
        </a>
    </div>
</div>