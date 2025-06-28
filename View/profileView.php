<?php
  session_start();
  if(isset($_SESSION['user'])){
    require_once('../Model/alldb.php');
    $res=getUserData($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Management</title>
  <link rel="stylesheet" href="../index.css">
  <style>
    .profile-title {
      color: var(--foreground);
      font-size: 2rem;
      font-weight: 700;
      margin: 2rem 0;
      text-align: center;
    }

    .profile-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 2rem;
      margin: 2rem auto;
      max-width: 600px;
      position: relative;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 2rem;
    }

    .profile-picture-section {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }

    .profile-picture {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 4px solid var(--primary);
      object-fit: cover;
      background: var(--secondary);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3rem;
      color: var(--muted-foreground);
    }

    .profile-picture img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
    }

    .edit-button {
      background: var(--primary);
      color: var(--primary-foreground);
      border: none;
      border-radius: 8px;
      padding: 0.5rem 1rem;
      font-size: 0.9rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .edit-button:hover {
      background: var(--primary-foreground);
      color: var(--primary);
      transform: translateY(-1px);
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .form-label {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--foreground);
      margin-bottom: 0.25rem;
    }

    .form-input {
      padding: 0.875rem 1rem;
      border: 1px solid var(--border);
      border-radius: 8px;
      background: var(--input);
      color: var(--foreground);
      font-size: 1rem;
      transition: all 0.2s ease;
    }

    .form-input:disabled {
      background: var(--muted);
      color: var(--muted-foreground);
      cursor: not-allowed;
      opacity: 0.7;
    }

    .form-input:focus:not(:disabled) {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px var(--ring);
    }

    .password-input {
      position: relative;
    }

    .password-toggle {
      position: absolute;
      right: 0.75rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      padding: 0.25rem;
      color: var(--muted-foreground);
      font-size: 1.1rem;
    }

    .card-footer {
      display: flex;
      justify-content: flex-end;
      padding-top: 1rem;
      border-top: 1px solid var(--border);
    }

    .save-button {
      background: var(--chart-2);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 0.75rem 1.5rem;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .save-button:hover {
      background: rgb(25, 150, 70);
    }

    .joined-date {
      color: var(--muted-foreground);
      font-style: italic;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
      .profile-card {
        margin: 1rem;
        padding: 1.5rem;
      }

      .card-header {
        flex-direction: column;
        gap: 1rem;
        align-items: center;
      }

      .profile-picture {
        width: 100px;
        height: 100px;
        font-size: 2.5rem;
      }

      .form-grid {
        gap: 1rem;
      }
    }
  </style>
</head>
<body>
  <header class="navbar">
    <div class="container">
      <a href="../index.php" class="logo">Weather App</a>
      <ul class="nav-links">
        <li><a href="../index.php">Home</a></li>
        <li><a href="forecastController.php">5-Day Forecast</a></li>
        <li><a href="historicalWeatherController.php">Historical Weather</a></li>
        <li><form action="../Controller/logoutController.php">
          <input type="submit" name="logout" value='Logout' class="btn btn-secondary">
        </form></li>
      </ul>
    </div>
  </header>
  
  <main class="main-content">
    <div class="container">
        <h1 class="profile-title">Manage Profile</h1>
        
        <!-- Profile Card -->
        <form action="../Controller/profileUpdateController.php" method="POST" class="profile-card">
          <div class="card-header">
            <div class="profile-picture-section">
              <div class="profile-picture">
                <!-- Profile picture placeholder - replace src with actual image -->
                <!-- <img src="profile-photo.jpg" alt="Profile Picture"> -->
                🤵
              </div>
            </div>
            
            <button class="edit-button">
              Edit Profile
            </button>
          </div>

          <div class="form-grid">
            <div class="form-group">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-input" value="<?php echo $res['name']; ?>" disabled>
            </div>

            <div class="form-group">
              <label class="form-label">Password</label>
              <div class="password-input">
                <input type="password" class="form-input" value="<?php echo $res['password']; ?>" disabled>
                <button type="button" class="password-toggle">View</button>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Phone Number</label>
              <input type="tel" class="form-input" value="<?php echo $res['phone_number']; ?>" disabled>
            </div>

            <div class="form-group">
              <label class="form-label">Joined Date</label>
              <input type="text" class="form-input joined-date" value="<?php echo $res['created_at']; ?>" disabled readonly>
            </div>

            <div class="form-group">
              <label class="form-label">Profile Photo</label>
              <input type="file" class="form-input" accept="image/*" disabled>
            </div>
          </div>

          <div class="card-footer">
            <button class="save-button">
              Save Changes
            </button>
          </div>
        </form>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const editButton = document.querySelector('.edit-button');
      const formInputs = document.querySelectorAll('.form-input:not([readonly])');
      const saveButton = document.querySelector('.save-button');
      
      let isEditing = false;

      editButton.addEventListener('click', function() {
        if (!isEditing) {
          // Enable editing mode
          formInputs.forEach(input => {
            input.disabled = false;
          });
          
          // Change button text and style
          editButton.textContent = 'Cancel Edit';
          editButton.style.background = 'var(--destructive)';
          editButton.style.color = 'white';
          
          isEditing = true;
        } else {
          // Cancel editing mode
          formInputs.forEach(input => {
            input.disabled = true;
          });
          
          // Reset button text and style
          editButton.textContent = 'Edit Profile';
          editButton.style.background = 'var(--primary)';
          editButton.style.color = 'var(--primary-foreground)';

          isEditing = false;
        }
      });

      // Add click handler for save button
      saveButton.addEventListener('click', function() {
        if (isEditing) {
          // Here you would typically save the data
          alert('Profile saved successfully!');
          
          // Reset to view mode
          formInputs.forEach(input => {
            input.disabled = true;
          });
          
          editButton.textContent = 'Edit Profile';
          editButton.style.background = 'var(--primary)';
          editButton.style.color = 'var(--primary-foreground)';
          
          saveButton.style.opacity = '0.8';
          saveButton.style.transform = 'scale(1)';
          
          isEditing = false;
        }
      });
    });
  </script>
</body>
</html>

<?php }
else{
  header('location: ../index.php');
}
?>