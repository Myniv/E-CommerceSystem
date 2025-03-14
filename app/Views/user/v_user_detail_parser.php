<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="d-flex justify-content-between">
                {!backButton!}
                {!editButton!}
            </div>
            <div class="card shadow">
                <div class="card-body text-center">
                    <!-- Profile Picture -->
                    <img src="{profile_picture}" alt="{name}" class="rounded-circle mb-3"
                        style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #ddd;">

                    <!-- <h4 class="card-title">{full_name}</h4> -->
                    <h4 class="card-title">{full_name}</h4>
                    <h6 class="text-muted">{role}</h6>
                    <hr>

                    <div class="row text-start">
                        <div class="col-6">
                            <p><strong>Username:</strong> {username}</p>
                            <p><strong>Email:</strong> {email}</p>
                            <!-- <p>{!activity_history!}</p> -->
                        </div>
                        <div class="col-6">
                            <p><strong>Status:</strong> {status}</p>
                            <p><strong>Last Login:</strong> {last_login}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>