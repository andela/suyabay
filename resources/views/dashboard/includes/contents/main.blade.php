<div class="col s12 m9">

    <div class="row">
        
        <!-- 
        Top panel: containes recent and information about suyabay
        #########################################################

        # Total users
        # Online users
        # 
        # 
        -->
        <div>
            <div class="col s12 m3">
                <div class="card-panel teal panel-container">
                    <span class="white-text">
                        <p>Users</p>
                        <h1>500K</h1>
                    </span>
                </div>
            </div>
          
            <div class="col s12 m3 ">
                <div class="card-panel teal panel-container">
                    <span class="white-text">
                        <p>Online</p>
                        <h1>500K</h1>
                    </span>
                </div>
            </div>
            <div class="col s12 m3 ">
                <div class="card-panel teal panel-container">
                    <span class="white-text">
                        <p>Users</p>
                        <h1>500K</h1>
                    </span>
                </div>
            </div>
          
            <div class="col s12 m3 ">
                <div class="card-panel teal panel-container">
                    <span class="white-text">
                        <p>Online</p>
                        <h1>500K</h1>
                    </span>
                </div>
            </div>
        </div>  

        <!-- 
        Episode tab controller
        ######################
        
        # Tab controller
        # Recent Episode
        # Pending Episode
        # Active Episode
        -->
        <div class="row">
            
            <!-- 
            # Tab controller
            -->
            <div class="col s12">
                <h4>Episodes</h4>
                <ul class="tabs">
                    <li class="tab col s3"><a class = "active" href="#test1">Recent Episodes</a></li>
                    <li class="tab col s3"><a class="" href="#test2">Pending Episodes</a></li>
                    <li class="tab col s3"><a class="" href="#test3">Active Episodes</a></li>
                </ul>
            </div>
            
            <!-- 
            # Recent Episode
            -->
            <div id="test1" class="col s12 tab-container">
                <table class="striped">
                    <thead>
                        <tr>
                            <th data-field="id">S/N</th>
                            <th data-field="name">Title</th>
                            <th data-field="price">Channel</th>
                            <th data-field="price">Created At</th>
                            <th data-field="price">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>How to Ginger the Suya</td>
                            <td>Andela Suaya Lovers</td>
                            <td>12 days ago</td>
                            <td width="150px;">      
                                <select id="emeka" class="browser-default" onclick="emeka()">
                                    <option style="width:2ppx;" selected>Select</option>
                                    <option value="1">View</option>
                                    <option value="delete">Delete</option>
                                    <option value="1">Active</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <!-- 
            # Pending Episode
            -->
            <div id="test2" class="col s12 tab-container">

                <table class="striped">
                    <thead>
                        <tr>
                            <th data-field="id">S/N</th>
                            <th data-field="name">Title</th>
                            <th data-field="price">Channel</th>
                            <th data-field="price">Created At</th>
                            <th data-field="price">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Eclair</td>
                            <td>$0.87</td>
                            <td>$0.87</td>
                            <td>      
                                <select  class="browser-default">
                                    <option style="width:2ppx;" selected>Select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- 
            # Active Episode
            -->
            <div id="test3" class="col s12 tab-container">

                <table class="striped">
                    <thead>
                        <tr>
                            <th data-field="id">S/N</th>
                            <th data-field="name">Title</th>
                            <th data-field="price">Channel</th>
                            <th data-field="price">Created At</th>
                            <th data-field="price">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Eclair</td>
                            <td>$0.87</td>
                            <td>$0.87</td>
                            <td>      
                                <select  class="browser-default">
                                    <option style="width:2ppx;" selected>Select</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
