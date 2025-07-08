CREATE TABLE manutencao_prevista (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_imobilizado INT NOT NULL,
    prox_manutencao DATE NOT NULL,
    ultima_manutencao DATE,
    intervalo_manutencao INT NOT NULL, -- em dias, por exemplo
    FOREIGN KEY (id_imobilizado) REFERENCES imobilizados(id)
);

CREATE TABLE manutencao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_imobilizado INT NOT NULL,
    id_fornecedor INT,
    dt_envio DATE NOT NULL,
    dt_retorno DATE,
    status VARCHAR(20),
    descricao_problema TEXT,
    observacoes TEXT,
    valor DECIMAL(10,2),
    FOREIGN KEY (id_imobilizado) REFERENCES imobilizados(id),
    FOREIGN KEY (id_fornecedor) REFERENCES fornecedores(id)
);
