    <div class="engagement-grid">
      @foreach (\App\Support\SiteContent::engagementModels() as $model)
      <div class="engagement-card reveal">
        <h3>{{ $model->title }}</h3>
        <ul>
          @foreach ($model->features as $feature)
          <li>{{ $feature->text }}</li>
          @endforeach
        </ul>
      </div>
      @endforeach
    </div>
