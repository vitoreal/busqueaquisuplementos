INSERT INTO `perfil` (`id`, `nome`) VALUES
(1, 'Administrador ROOT'),
(2, 'Administrador'),
(3, 'Usuário comum');

INSERT INTO `menu` (`id`, `nome`, `url`, `id_menu`, `posicao`, `icone`, `ordem`) VALUES
(1, 'Administrar', '#', NULL, 'ADMINISTRADOR', 'fa fa-cogs fa-lg', 1000),
(2, 'Conteúdo', 'conteudo/view', 1, 'SUBMENU', NULL, 0),
(3, 'Usuários', 'usuario/view', 1, 'SUBMENU', NULL, 0),
(4, 'Menu', 'menu/view', 1, 'SUBMENU', NULL, 0),
(5, 'Métodos', 'metodo/view', 1, 'SUBMENU', '', 0),
(6, 'Página Inicial', 'principal/view', NULL, 'LATERAL', 'iconecor-home iconecor-24', 1);
(7, 'Clientes', 'cliente/view', NULL, 'LATERAL', 'iconecor-cliente iconecor-24', 2);
(5, 'Métodos', 'metodo/view', 1, 'SUBMENU', '', 0),

INSERT INTO `menu_perfil` (`id`, `id_menu`, `id_perfil`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1);

INSERT INTO `metodos` (`id`, `classe`, `metodo`, `nome`) VALUES
(1, 'usuario', 'view', 'usuario/view'),
(2, 'usuario', 'listar', 'usuario/listar'),
(3, 'usuario', 'formCadastrar', 'usuario/formCadastrar'),
(4, 'usuario', 'actionCadastrar', 'usuario/actionCadastrar'),
(5, 'usuario', 'formAlterar', 'usuario/formAlterar'),
(6, 'usuario', 'actionAlterar', 'usuario/actionAlterar'),
(7, 'usuario', 'actionExcluir', 'usuario/actionExcluir'),
(8, 'usuario', 'formAlterarSenha', 'usuario/formAlterarSenha'),
(9, 'usuario', 'actionAlterarSenha', 'usuario/actionAlterarSenha'),
(10, 'menu', 'view', 'menu/view'),
(11, 'menu', 'listar', 'menu/listar'),
(12, 'menu', 'formCadastrar', 'menu/formCadastrar'),
(13, 'menu', 'actionCadastrar', 'menu/actionCadastrar'),
(14, 'menu', 'formAlterar', 'menu/formAlterar'),
(15, 'menu', 'actionAlterar', 'menu/actionAlterar'),
(16, 'menu', 'actionExcluir', 'menu/actionExcluir'),
(17, 'menu', 'formCadastrarPermissao', 'menu/formCadastrarPermissao'),
(18, 'menu', 'actionCadastrarPermissao', 'menu/actionCadastrarPermissao'),
(19, 'metodo', 'view', 'metodo/view'),
(20, 'metodo', 'listar', 'metodo/listar'),
(21, 'metodo', 'formCadastrarPermissao', 'metodo/formCadastrarPermissao'),
(22, 'metodo', 'actionCadastrarPermissao', 'metodo/actionCadastrarPermissao'),
(23, 'metodo', 'formAlterar', 'metodo/formAlterar'),
(24, 'metodo', 'actionAlterar', 'metodo/actionAlterar'),
(25, 'metodo', 'actionExcluir', 'metodo/actionExcluir'),
(26, 'conteudo', 'view', 'conteudo/view'),
(27, 'conteudo', 'listar', 'conteudo/listar'),
(28, 'conteudo', 'formCadastrar', 'conteudo/formCadastrar'),
(29, 'conteudo', 'actionCadastrar', 'conteudo/actionCadastrar'),
(30, 'conteudo', 'formAlterar', 'conteudo/formAlterar'),
(31, 'conteudo', 'actionAlterar', 'conteudo/actionAlterar'),
(32, 'conteudo', 'actionExcluir', 'conteudo/actionExcluir'),
(33, 'conteudo', 'formImagem', 'conteudo/formImagem'),
(34, 'conteudo', 'actionCadastrarImagem', 'conteudo/actionCadastrarImagem'),
(35, 'conteudo', 'actionExcluirImagem', 'conteudo/actionExcluirImagem'),
(36, 'conteudo', 'carregarImagens', 'conteudo/carregarImagens'),
(37, 'principal', 'view', 'principal/view');

INSERT INTO `permissoes` (`id`, `id_metodos`, `id_perfil`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 1),
(17, 17, 1),
(18, 18, 1),
(19, 19, 1),
(20, 20, 1),
(21, 21, 1),
(22, 22, 1),
(23, 23, 1),
(24, 24, 1),
(25, 25, 1),
(26, 26, 1),
(27, 27, 1),
(28, 28, 1),
(29, 29, 1),
(30, 30, 1),
(31, 31, 1),
(32, 32, 1),
(33, 33, 1),
(34, 34, 1),
(35, 35, 1),
(36, 36, 1),
(37, 37, 1);

INSERT INTO `status` (`id`, `nome`) VALUES
(1, 'Aprovado'),
(2, 'Aguardando Aprovação');

INSERT INTO `usuario` (`id`, `id_status`, `id_perfil`, `nome`, `email`, `login`, `senha`, `dtcadastro`) VALUES
(1, 1, 1, 'Vitor Almeida2', 'atendimento@futebolfan.com.br', 'root', 'e10adc3949ba59abbe56e057f20f883e', '2015-01-04 13:13:05'),
(2, 1, 2, 'Gustavo', 'guta@guta.com.br', 'guta', 'e10adc3949ba59abbe56e057f20f883e', '2015-10-08 00:00:00');

INSERT INTO `tipo_conteudo` (`id`, `nome`) VALUES
(1, 'Quem Somos'),
(2, 'Contato'),
(3, 'Política e Privacidade');
