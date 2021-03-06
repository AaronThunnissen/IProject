

CREATE TABLE Users
( 
  Username VARCHAR(200),
  Postalcode VARCHAR(9),
  Location VARCHAR(MAX),
  Country VARCHAR(100),
  Rating NUMERIC(4,1) 
)


CREATE TABLE Items
(
	ID bigint NOT NULL,
	Titel varchar(max) NULL,
	Beschrijving nvarchar(max) NULL,
	Categorie int NULL,
	Postcode varchar(max) NULL,
	Locatie varchar(max) NULL,
	Land varchar(max) NULL,
	Verkoper varchar(max) NULL,
	Prijs varchar(max) NULL,
	Valuta varchar(max) NULL,
	Conditie varchar(max) NULL,
	Thumbnail varchar(max) NULL,
	CONSTRAINT PK_Items PRIMARY KEY (ID),)

CREATE TABLE Illustraties
(
	ItemID bigint NOT NULL,
	IllustratieFile varchar(100) NOT NULL,
    CONSTRAINT PK_ItemPlaatjes PRIMARY KEY (ItemID, IllustratieFile),
	CONSTRAINT [ItemsVoorPlaatje] FOREIGN KEY(ItemID) REFERENCES Items (ID)
)


CREATE INDEX IX_Items_Categorie ON Items (Categorie)