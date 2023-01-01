# Wdrożene i architektura

Do działania projektu potrzebne jest utworzoenie bazy danych MySQL, skonfigurowanie danych dostępu w src/Core/Database.php i wykonanie wszystkich poleceń 
z pliku ecom.sql.

1. Katalog images przechowuje zapisane obrazy.
2. Katalog src składa się z katalogów:
  - Config - katalog konfiguracyjny, plik routes.php zawiera ścieżki dostępu do kontrolerów i widoków, natomiast plik helpers.php zawiera funkcje
    pomocnicze, takie jak np. zmiana lokalizacji.
  - Controller - w katalogu znajdują się kontrolery.
  - Core - katalog w którym znajduje się konfiguracja bazy danych, a także konfiguracja ściezek.
  - Models - w katalogu znajdują się modele komunikujące się z bazą danych, wykorzystywane są w kontrolerach.
2. W katalogu Templates zawarte są wszystkie pliki html wyświetlane za pomocą routes.php, znajdują się tu także skrypty js i style css.
3. index.php spaja w całość projekt, konfigurowany jest przez plik .htaccess.
