<!-- Modal -->
    <div class="modal fade" id="myModal-login" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4><span class="glyphicon glyphicon-unlock"></span> Login</h4>
          </div>
          <div class="modal-body">
          
            <form role="form" action="index.php?application=login&class=login&action=login" method="post" >
              <div class="form-group">
                <label for="pseudo"><span class="glyphicon glyphicon-user"></span> Pseudo</label>
                <input type="text" class="form-control" name="pseudo" placeholder="Votre pseudo">
              </div>
              <div class="form-group">
                <label for="psw"><span class="glyphicon glyphicon-lock"></span> Mot de passe</label>
                <input type="password" class="form-control" name="pwd" placeholder="Votre mot de passe">
              </div>
              <button type="submit" class="btn btn-block btn-default">Login
                <span class="glyphicon glyphicon-ok"></span>
              </button>
            </form>
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal">
              <span class="glyphicon glyphicon-remove"></span> Cancel
            </button>
            <p>Need <a href="#">help?</a></p>
            <p ><a href="index.html">Forgot your password?</a></p>
            <p ><a href='index.php?application=login&class=registration'>Don't have an account? Join us</a></p>
          </div>
        </div>
      </div>
    </div>