<!DOCTYPE.html>
    <html>


    <head>
        <title>Form</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    </head>

    <style>
    /*iv {
                margin: auto;
            width: 75%;
            border-radius: 50px;
            background-color: #989e98;
            padding: 10px;
            }
            */
    /* input[type=text],
            select {
                width: 10%;
                padding: 12px 12px;
                margin: 8px 4px;
                border: 2px solid #ccc;
                border-radius: 40px;
                }
                
                input[type=tel],
                select {
                    width: 10%;
                    padding: 12px 12px;
                    margin: 8px 4px;
                    border: 2px solid #ccc;
                    border-radius: 40px;
                    }
                    
                    input[type=email],
                    select {
                        width: 10%;
                        padding: 12px 12px;
                        margin: 8px 4px;
                        border: 2px solid #ccc;
                        border-radius: 40px;
                        }
                        
                        input[type=number],
                        select {
                            width: 10%;
                            padding: 12px 12px;
                            margin: 8px 4px;
                            border: 2px solid #ccc;
                            border-radius: 40px;
                            } */
    .inputs {
        width: 10%;
        padding: 12px 12px;
        margin: 8px 4px;
        border: 2px solid #ccc;
        border-radius: 40px;
    }

    input[type=submit] {
        width: 10%;
        background-color: #4CAF50;
        color: white;
        padding: 12px 12px;
        margin: 8px 4px;
        border: 2px;
        border-radius: 40px;
        cursor: pointer;
    }

    input[type=reset] {
        width: 10%;
        background-color: #4CAF50;
        color: white;
        padding: 12px 12px;
        margin: 8px 4px;
        border: 2px;
        border-radius: 40px;
        cursor: pointer;
    }
    </style>


    <body>
        <b>

            <div class="col-md-12 ">
                <form>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    Please Enter Your Details Here
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6  ">
                                            <label for="name">First Name:</label>
                                            <input type="text" name="fname" class="form-control"
                                                placeholder="Fist name">
                                        </div>
                                        <div class="col-md-6 ">
                                            <label for="lname">Last Name:</label>
                                            <input type="text" name="lname" class=" form-control"
                                                placeholder="Last Name">
                                        </div>
                                        <!-- <label for="mname">Middle Name:</label><br> -->
                                        <!-- <input type="text" name="mname" class="inputs" placeholder="Middle name"><br> -->
                                        <div class="col-md-4 mt-3  ">
                                            <label for="age">Date Of Birth:</label>
                                            <input type="date" name="age" class="form-control" placeholder="age">

                                        </div>
                                        <div class="col-md-4 mt-3  ">
                                            <label for="tel">Mobile No:</label>
                                            <input type="tel" name="tel" class="form-control"
                                                placeholder="Enter Your Mobile Number">

                                        </div>
                                        <div class="col-md-4 mt-3 ">
                                            <label for="Blood Group">Blood Group</label>
                                            <input type="text" name="Blood group" class="form-control"
                                                placeholder="Blood Group">

                                        </div>
                                        <div class="col-md-3 mt-3 col-md-2">
                                            <label for="Email">Email ID:</label>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="abc123@gmail.com">
                                        </div>
                                        <div class="col-md-5 mt-3">
                                            <label for="Gender">Gender:</label><br>
                                            <input type="radio" name="Gender">Male <input type="radio"
                                                name="Gender">Female
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label for="avatar">Upload Your Photo*</label>
                                            <input type="file" name="avatar " id="">
                                        </div>
                                        <div class="col-md-2 mt-3 ms-2">
                                            <label for="Height">Height:</label><br>
                                            <input type="Number" name="Height" class="form-control"
                                                placeholder="in cms">
                                        </div>
                                        <div class="col-md-5 mt-3">
                                            <label for="weight">weight:</label>
                                            <input type="Number" name="Weight" class="form-control"
                                                placeholder="in kgs">
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label for="Address">Address:</label>
                                            <input type="text" name="Address" class="form-control"
                                                placeholder="Address">
                                        </div>
                                        <div class="col-md-2 mt-3 ms-2">
                                            <label for="Landmark">Landmark:</label>
                                            <input type="text" name="Landmark" class="form-control"
                                                placeholder="Landmark">
                                        </div>
                                        <div class="col-md-5 mt-3">
                                            <label for="city">City:</label>
                                            <input type="text" name="City" class="form-control" placeholder="City">
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label for="state">State:</label>
                                            <input type="text" name="State" class="form-control" placeholder="State">
                                        </div>
                                        <div class="col-md-2 mt-3 ms-2">
                                            <label for="pincode">Pincode:</label><br>
                                            <input type="number" name="pincode" class="form-control"
                                                placeholder="Pincode">
                                        </div>
                                        <div class="col-md-5 mt-3">
                                            <label for="Country">Country:</label><br>
                                            <!-- <input type="text" name="Country" class="inputs"> -->
                                            <select id="country" name="country" class="form-control">
                                                <option value="australia">Australia</option>
                                                <option value="India">India</option>
                                                <option value="usa">USA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    Educational Details
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <label for=School>School Name:</label>
                                        <input type="text" name="School" class="form-control" placeholder="School Name">
                                    </div>
                                    <div class="col-md-6">

                                        <label for="Marks">Marks In 10th:</label>
                                        <input type="number" name="Marks" class="form-control" placeholder="Marks">
                                    </div>
                                    <div class="col-md-4 mt-3 ">
                                        <label for="Year">Year of Passing:</label>
                                        <input type="number" name="Year" class="form-control"
                                            placeholder="Year Of Passing">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="Collegename">College Name:</label>
                                        <input type="text" name="Collegename" class="form-control"
                                            placeholder="Collegename">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="Marks">Marks In 12th:</label>
                                        <input type="number" name="Marks" class="form-control" placeholder="Marks">
                                    </div>
                                    <div class="col-md-4 mt-3 ">
                                        <label for="Year">Year of Passing:</label>
                                        <input type="number" name="Year" class="form-control"
                                            placeholder="Year Of Passing">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="university">University Name:</label>
                                        <input type="text" name="universityname" class="form-control"
                                            placeholder="University Name">
                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <label for="Department">Graduation in:</label>
                                        <input type="text" name="Department" class="form-control" placeholder="Course">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label for="Year">Year of Passing:</label>
                                        <input type="number" name="Year" class="form-control"
                                            placeholder="Year Of Passing">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        Submit
                                    </button>
                                    <input type="reset" name="reset">
                                    <input type="checkbox" name="Checkbox">
                                    <label for="checkbox"> I agree Terms And condition</label>

                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </b>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>