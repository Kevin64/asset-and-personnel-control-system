<div id="menu">
	<nav>
		<ul>
			<li>
				<a href="index.php">Home</a>
			</li>
			<li>
				<label for="touch"><span>Patrimônio</span></label>
				<input type="checkbox" id="touch">
				<ol class=slide>
					<li><a href="consultarPatrimonio.php">Consultar Patrimônio</a></li>
					<li><a href="frmCadBIOS.php">Cadastrar Modelo de Hardware</a></li>
					<li><a href="consultarBIOS.php">Consultar Modelo de Hardware</a></li>
				</ol>
			</li>
			<li>
				<span>Docentes</span>
				<ol>
					<a href="frmCadDocente.php">Cadastrar Docentes</a>
					<a href="consultarDocente.php">Consultar Docentes</a>
				</ol>
			</li>
			<li>
				<a href="sobre.php">Sobre</a>
			</li>
			<li>
				<?php
				if (!isset($_SESSION["id"])) {
				?>
					<span>Usuário desconectado</span>
				<?php
				} else {
				?>
					<span>
						<?php
						echo "Logado como: " . $_SESSION["usuario"];
						?>
					</span>
				<?php
				}
				?>

				<ol>
					<?php
					/* if (!isset($_SESSION["id"]))
				{
				?>

				<li><a href=frmLogin.php>Entrar</a></li>
				<li><a href=frmCadastro.php>Cadastrar</a></li>

				<?php
				}
				else
				{ */
					if (isset($_SESSION['nivel'])) {
						if ($_SESSION["nivel"] == "adm") {
					?>

							<a href="consultarUsuario.php">Listar Usuários</a>
							<a href="frmAddUsuario.php">Adicionar Usuário</a>
							<a href="frmTrocarSenha.php">Alterar senha</a>
							<a href="logout.php">Sair</a>

						<?php
						} else {
						?>

							<a href="frmTrocarSenha.php">Alterar senha</a>
							<a href="logout.php">Sair</a>
					<?php
						}
					}
					?>
				</ol>
			</li>
		</ul>
	</nav>
</div>