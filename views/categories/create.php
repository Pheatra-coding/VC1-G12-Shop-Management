 <style>
     /* Reset default styles */
     * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
     }

     .main {
         max-width: 1200px;
         margin: 0 auto;
         padding: 20px;
     }

     /* Form Container Styling */
     .form-container {
         background-color: #ffffff;
         padding: 20px;
         border-radius: 8px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         margin-bottom: 30px;
     }

     .form-container h2 {
         color: #333;
         margin-bottom: 20px;
         font-size: 24px;
     }

     .form-group {
         margin-bottom: 15px;
     }

     .form-group label {
         display: block;
         margin-bottom: 5px;
         color: #555;
         font-weight: 500;
     }

     .form-group input {
         width: 100%;
         padding: 8px 12px;
         border: 1px solid #ddd;
         border-radius: 4px;
         font-size: 16px;
         transition: border-color 0.3s ease;
     }

     .form-group input:focus {
         outline: none;
         border-color: #007bff;
     }

     .form-group button {
         background-color: #007bff;
         color: white;
         padding: 10px 20px;
         border: none;
         border-radius: 4px;
         cursor: pointer;
         font-size: 16px;
         transition: background-color 0.3s ease;
     }

     .form-group button:hover {
         background-color: #0056b3;
     }

     /* Category List Styling */
     .category-list {
         background-color: #ffffff;
         padding: 20px;
         border-radius: 8px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
     }

     .category-list h2 {
         color: #333;
         margin-bottom: 20px;
         font-size: 24px;
     }

     table {
         width: 100%;
         border-collapse: collapse;
     }

     thead {
         background-color: #f8f9fa;
     }

     td {
         padding: 12px 15px;
         border-bottom: 1px solid #eee;
         color: #444;
     }

     tbody tr:hover {
         background-color: #f5f5f5;
     }

     /* Responsive Design */
     @media (max-width: 768px) {
         .main {
             padding: 10px;
         }

         .form-container,
         .category-list {
             padding: 15px;
         }

         td {
             padding: 8px 10px;
         }

         .form-group button {
             width: 100%;
         }
     }
 </style>
 </head>

 <body>
     <main id="main" class="main">
         <div class="form-container">
             <h2>Create Category</h2>
             <?php if (isset($errors['general'])): ?>
                 <p style="color: red;"><?php echo htmlspecialchars($errors['general']); ?></p>
             <?php endif; ?>
             <form action="/categories/store" method="POST">
                 <div class="form-group">
                     <label for="category_name">Category Name</label>
                     <input type="text" id="category_name" name="category_name"
                         value="<?php echo isset($_POST['category_name']) ? htmlspecialchars($_POST['category_name']) : ''; ?>"
                         required>
                 </div>
                 <div class="mb-3">
                     <a href="/categories" class="btn btn-secondary" style="margin-right: 8px;">
                         <i class="fas fa-arrow-left me-2"></i> Back
                     </a>
                     <button type="submit" class="btn btn-primary">
                         <i class="fas fa-save me-2"></i> Create Category
                     </button>

                 </div>
                 <!-- List Categories -->
                 <div class="category-list">
                     <h2>Existing Categories</h2>
                     <?php if (count($categories) > 0): ?>
                         <table>
                             <thead>
                                 <tr>
                                     <td>Category Name</td>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php foreach ($categories as $category): ?>
                                     <tr>
                                         <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                                     </tr>
                                 <?php endforeach; ?>
                             </tbody>
                         </table>
                     <?php else: ?>
                         <p>No categories created yet.</p>
                     <?php endif; ?>
                 </div>
     </main>