import tkinter as tk
from tkinter import ttk
from datetime import datetime
from threading import Thread
import pystray
from PIL import Image, ImageDraw

# ---------- Funções principais ----------

def criar_icone():
    # Ícone minimalista para a bandeja
    img = Image.new('RGB', (64, 64), (245, 245, 245))
    draw = ImageDraw.Draw(img)
    draw.ellipse((12, 12, 52, 52), fill=(123, 104, 238))
    return img

def copiar_texto(frase):
    # Copia texto e mostra feedback
    janela.clipboard_clear()
    janela.clipboard_append(frase)
    status_label.config(text=f"✅ Copiado: {frase}")

def saudacao_automatica():
    # Saudação conforme horário
    hora = datetime.now().hour
    if hora < 12:
        return "Olá, bom dia!"
    elif hora < 18:
        return "Boa tarde!"
    else:
        return "Boa noite!"

def abrir_janela(icon=None, item=None):
    # Mostra/eleva a janela
    janela.after(0, janela.deiconify)
    janela.after(0, janela.lift)
    janela.after(0, lambda: janela.attributes('-topmost', True))

def esconder_janela():
    # Esconde a janela (fica na bandeja)
    janela.withdraw()

def iniciar_bandeja():
    # Ícone da bandeja com menu Abrir/Sair
    def sair(icon, item):
        icon.stop()
        janela.destroy()
    icone = pystray.Icon(
        "FrasesRápidas",
        criar_icone(),
        "Frases Rápidas",
        menu=pystray.Menu(
            pystray.MenuItem("Abrir", abrir_janela),
            pystray.MenuItem("Sair", sair)
        )
    )
    # modo que não bloqueia o Tkinter
    icone.run()

# ---------- Janela principal ----------
janela = tk.Tk()
janela.title("Frases Rápidas")
janela.geometry("320x350")
janela.configure(bg="#fdf6e3")
janela.minsize(250, 250)

# Container com rolagem (Canvas + Frame + Scrollbar)
container = tk.Frame(janela, bg="#fdf6e3")
container.pack(fill="both", expand=True, padx=10, pady=(10, 0))

canvas = tk.Canvas(container, bg="#fdf6e3", highlightthickness=0)
scrollbar = ttk.Scrollbar(container, orient="vertical", command=canvas.yview)
scrollable_frame = tk.Frame(canvas, bg="#fdf6e3")

# --- SCROLL: atualiza região rolável e largura do frame interno
def atualizar_scroll(_event=None):
    canvas.configure(scrollregion=canvas.bbox("all"))

def ajustar_largura(event):
    # Mantém o frame interno com a mesma largura do canvas
    canvas.itemconfigure("frame", width=event.width)

scrollable_frame.bind("<Configure>", atualizar_scroll)
canvas.bind("<Configure>", ajustar_largura)
canvas.create_window((0, 0), window=scrollable_frame, anchor="nw", tags="frame")

canvas.configure(yscrollcommand=scrollbar.set)
canvas.pack(side="left", fill="both", expand=True)
scrollbar.pack(side="right", fill="y")

# --- SCROLL: roda do mouse (Windows) e wheel (Linux/macOS)
def _on_mousewheel(event):
    # Windows/Mac enviam delta em múltiplos de 120; Linux usa Button-4/5
    if hasattr(event, "delta") and event.delta:
        delta = int(-event.delta / 120)
    elif getattr(event, "num", None) == 5:   # Linux: down
        delta = 1
    elif getattr(event, "num", None) == 4:   # Linux: up
        delta = -1
    else:
        delta = 0
    if delta != 0:
        canvas.yview_scroll(delta, "units")

def _bind_wheel(_event=None):
    canvas.bind_all("<MouseWheel>", _on_mousewheel)   # Windows/macOS
    canvas.bind_all("<Button-4>", _on_mousewheel)     # Linux
    canvas.bind_all("<Button-5>", _on_mousewheel)     # Linux

def _unbind_wheel(_event=None):
    canvas.unbind_all("<MouseWheel>")
    canvas.unbind_all("<Button-4>")
    canvas.unbind_all("<Button-5>")

canvas.bind("<Enter>", _bind_wheel)
canvas.bind("<Leave>", _unbind_wheel)

# --- Saudação dinâmica e frases
g = saudacao_automatica()  # calcula uma vez

frases = [
    g,  # "Olá, bom dia!" | "Boa tarde!" | "Boa noite!"
    """telysupport
ep2@YPl429PSy#
enable
62aDqGkOrIB3%M
show run""",
    "CNPJ Tely : 06.346.446.0001-59",
    "HORARIO DE QUEDA - ",
    "HORARIO DE VOLTA - ",
    "Contato N3 - 0800 731 1400 ",
    "Call Center - 0800 731 2020",
    f"Prezados, {g}",
    "Verificando, só um momento...",
    "Joia!",
    "Obrigado!",
    "Perfeito!",
    "Tudo certo!",
    "À disposição!",
    "Podemos prosseguir?",
    "Encaminhado conforme solicitado.",
    "Por gentileza, poderia verificar?",
    "Fico no aguardo do seu retorno.",
    "Qualquer dúvida, estou à disposição.",
    "Conforme conversamos anteriormente...",
    "Segue abaixo as informações solicitadas.",
    "Agradeço desde já o retorno.",
    "Excelente dia a todos!",
    "Bom trabalho!",
    "Cordialmente,"
]


# Botões
for frase in frases:
    tk.Button(
        scrollable_frame,
        text=frase,
        command=lambda f=frase: copiar_texto(f),
        font=("Segoe UI", 11),
        bg="#fff8dc",
        activebackground="#ffe4b5",
        relief="groove",
        bd=1,
        wraplength=250
    ).pack(padx=5, pady=4, fill='x')

# Status
status_label = tk.Label(
    janela,
    text="Clique em uma frase para copiar.",
    font=("Segoe UI", 9),
    bg="#fdf6e3",
    fg="#555"
)
status_label.pack(pady=5)

# Botão X apenas esconde (fica na bandeja)
janela.protocol("WM_DELETE_WINDOW", esconder_janela)

# Garante scroll disponível já na abertura
janela.update_idletasks()
atualizar_scroll()

# Bandeja (em thread separada)
Thread(target=iniciar_bandeja, daemon=True).start()

janela.mainloop()
