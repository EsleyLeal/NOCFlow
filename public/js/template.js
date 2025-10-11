const templates = {
  "E-MAIL PARCEIRO": `
[INDISPONIBILIDADE TELY] [PARCEIRO PROXXIMA] [CLIENTE TJRN-Extremoz-Sede da Comarca]

Prezados,

Um dos nossos clientes está alarmando indisponibilidade, é o [ORG].

Vlans: [VLAN]

CNPJ Tely : 06.346.446.0001-59

Ainda não temos uma confirmação do estado elétrico do local por parte do cliente.

Poderiam verificar se existe algum alarme que indique falta de energia no circuito ou problema físico no lado de vocês , por gentileza?

Ficamos no aguardo de um feedback.
  `,

  "UPTIME REINICIADO": `
Prezados,

O link retornou sem intervenção técnica. Uptime do equipamento foi reiniciado. Possível falha elétrica no local.

Estarei encerrando o chamado aberto.
  `,

  "ONU DESLIGADA": `
Prezados, [SAUDACAO]!

Identificamos em nosso monitoramento uma indisponibilidade na unidade.
Identificamos que a ONU se encontra desligada, ou seja, um possível problema elétrico no local.

Poderiam verificar se os nossos equipamentos estão devidamente energizados no local ?

Atenciosamente,
  `,

  "EMAIL MASSIVO": `
Assunto Tely Atendimento - Número: [PROTOCOLO]

Prezado(a) cliente,

Gostaríamos de informá-lo(a) que no dia [DATA] ocorreu um rompimento de fibra, o que causou uma indisponibilidade temporária na região em que sua conexão está localizada. Nossa equipe já trabalhou para resolver o problema e gostaríamos de saber se o serviço está funcionando normalmente agora.

Pedimos desculpas pelo transtorno que isso possa ter causado e agradecemos pela sua compreensão durante esse período. Caso ainda esteja enfrentando algum problema, por favor, entre em contato conosco imediatamente para que possamos ajudar a solucionar o problema.

NOC Tely
Atenciosamente,
  `,

  "FALTA DE INTERAÇÃO": `

Infelizmente, não conseguimos estabelecer contato com o cliente para solucionar o problema relatado. Apesar de nossas tentativas, o cliente não respondeu a nossas chamadas e não entrou em contato novamente para informar se o problema persistia. Realizamos uma verificação da conexão do cliente e constatamos que ela estava normalizada.

Enviamos um e-mail para informar sobre nossas tentativas de contato, mas não obtivemos resposta. Por falta de interação com o cliente, o chamado foi encerrado.

NOC Tely
Atenciosamente,
  `,

  "24 Horas": `

Prezado(a) Cliente,

Tentamos contatos telefônicos, porém não tivemos sucesso. Gostaríamos de informá-lo(a) que não havia problemas com a conexão e o serviço está normalizado.

Gostaríamos de pedir que, por gentileza, nos confirme se está tudo funcionando corretamente agora. Caso não tenhamos resposta em até 24 horas, consideraremos o chamado -- como encerrado. Se você ainda tiver algum problema ou dúvida adicional, por favor, não hesite em entrar em contato com nosso suporte técnico.

Atenciosamente,
NOC - TELY,`,


"ESCOLA": `
Prezados, [SAUDACAO]!

Protocolo gerado para o atendimento: [PROTOCOLO]

Identificamos que a ONU se encontra com alarme de LINK LOSS, ou seja, um possível rompimento de fibra.

Estamos encaminhando para o suporte de manutenção.

Atenciosamente,`,

"ABERTURA SZ RBX E EMAIL": `
➢ Nome do Solicitante: [NOME]
➢ Contato: [CONTATO]
➢ E-mail: [EMAIL]
➢ Relato do cliente: [RELATO]
`,

"ABERTURA SZ RBX": `
➢ Nome do Solicitante via sz: [NOME]
➢ Contato via sz: [CONTATO]
➢ Relato do cliente: [RELATO]
`,

"GOV INDISPONIBILIDADE": `

Prezados, [SAUDACAO].


Estamos sem comunicação com o nosso equipamento no local. Poderia validar se o CPE está devidamente energizado, por gentileza?

Ficamos no aguardo da sua resposta para prosseguirmos com a tratativa.


Atenciosamente,
`,

"GOV INDISPONIBILIDADE (QUANDO NÃO RESPONDEM)": `

Prezados, [SAUDACAO].

Seguimos no aguardo de um retorno referente ao estado dos equipamentos no local. Poderiam validar se os nosso equipamentos estão devidamente energizados, por gentileza?

Ficamos no aguardo da sua resposta para prosseguirmos com a tratativa.

Atenciosamente,
`,

"CNPJ TELY": `
CNPJ Tely : 06.346.446.0001-59
`,

"GOV - UPTIME NAO REINICIADO": `

Estavamos com uma indisponibilidade no link de [ORG].


O link retornou sem uptime reiniciado, poderiam nos informar a causa da indisponibilidade e a tratativa, por gentileza ?


VLANS : [VLAN]


CNPJ TELY: 06.346.446.0001-59



Atenciosamente,
NOC TELY.
`,

"CLIENTE DESLIGOU O CPE": `

Prezados, [SAUDACAO]!

Tendo em vista que houve confirmação por parte dos responsáveis informando que o equipamento está desligado, estamos encerrando o chamado. Caso os senhores retorne, abriremos outro chamado.


Atenciosamente,
NOC Tely
`,

"PROBLEMA NO POP DO PARCEIRO": `

Prezados,

Informamos que o chamado foi encerrado. Seguem os detalhes do incidente:

Motivo: Ocorrência de problema elétrico no POP que atende a unidade.


Data e hora do incidente: [DATA]


Ação: Após a correção do problema elétrico, os serviços foram restabelecidos.


Data e hora da normalização: [DATA].


Permanecemos à disposição para quaisquer esclarecimentos.

Atenciosamente,
NOC Tely

`,


};
