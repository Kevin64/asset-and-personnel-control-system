<div id="menu">
	<ul>
		<li>
			<a href="index.php">Home</a>
		</li>
		<li>
			<span>Patrimônio</span>
			<ol>
				<li><a href="frmCadPatrimonio.php">Cadastrar Patrimônio</a></li>
				<li><a href="consultarPatrimonio.php">Consultar Patrimônio</a></li>
				<li><a href="frmCadBIOS.php">Cadastrar BIOS/UEFI</a></li>
				<li><a href="consultarBIOS.php">Consultar BIOS/UEFI</a></li>
			</ol>
		</li>
		<li>
			<span>Docentes</span>
			<ol>
				<li><a href="frmCadDocente.php">Cadastrar Docentes</a></li>
				<li><a href="consultarDocente.php">Consultar Docentes</a></li>
			</ol>
		</li>
		<li>
			<a href="sobre.php">Sobre</a>
		</li>
		<li>
			<span>
			<?php
			if (!isset($_SESSION["id"]))
			{
			?>

			<?php
			}
			else
			{
				echo "Logado como: ".$_SESSION["usuario"];
			}
			?>

			</span>
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
					if ($_SESSION["nivel"] == "adm")
					{
				?>

				<li><a href="frmAddUsuario.php">Adicionar Usuário</a></li>
				<li><a href="frmTrocarSenha.php">Alterar senha</a></li>
				<li><a href="logout.php">Sair</a></li>

				<?php
					} else {
				?>

				<li><a href="frmTrocarSenha.php">Alterar senha</a></li>
				<li><a href="logout.php">Sair</a></li>
				<?php
				}
				?>
			</ol>
		</li>
	</ul>
</div>

