# Interactive database of educational materials on academic integrity

---

Author: [Jan Martinek](https://is.muni.cz/auth/osoba/484967)
Lead: [Mgr. Tomáš Foltýnek, Ph.D.](https://is.muni.cz/auth/osoba/4374)
Consultant: [Ing. Dita Dlabová, Ph.D.](https://is.muni.cz/auth/osoba/didl)

---

## Contents
- Introduction
	- Overview
	- Objectives
	- Methodology
- Analysis and model design
	- Functional requirements
	- Non-functional requirements
	- Use-case model
	- ERD model
	- Class model ??
- Implementation
- Conclusion
- Literature
- Attached files

---

## Introduction

### Overview

It's a known fact that nowadays the world is largely interconnected. One of the main actors is the internet. More than sixty-three percent of people from all around the world can use it. With this connection, it became possible to observe many changes. Mainly an easy way to share and spread information. Of course, such property comes with certain drawbacks. Aside from mixing truths and falsehoods, the one that plagues most people across the whole digitalized society is information overload. Information overload can be defined as a phenomenon that occurs when one has access to more information than they can handle. It happens daily, affecting basically everybody, be it public or the academics. In particular, it is the students and teachers who form a group of people that uses the internet for getting important study materials, and it can be hard to filter useful ones among heaps of worthless. It also needs to be considered that not every institution is able to provide its own library of study materials.

With that being the case, is there a way of reducing the scope to help alleviate this negative, whilst still retaining the positives? The obvious way is to introduce a trusted site that collects or creates reviewed and verified and makes them publicly available. European network for academic integrity is an organization that provides one such site.

### Objectives

The aim of the thesis was to rework an existing WordPress plugin into a standalone PHP application. The plugin served as an interactive database of educational materials and was originally created for use by ENAI mentioned at the end of the previous section, but also publicly available for anyone else.

The application will enable administrators to manage posts. The management will have ordinary features like changing title, description or metadata but also adding links or separate files to the posts. In case of files uploading, storage and removal is to be provided by the application itself. Any user of the application will be able to view any publicized post and rate it, which will provide support for the 'favourites' view on the main page. Filtering will be possible via metadata, along with search functionality by title. Design will try to match the academic integrity website. Application will contain documentation inside of source code.

### Methodology

The first step was a quick review of the plugin, followed by communication with a personnel from ENAI and a more thorough analysis. Since the plugins' introduction, there appeared to be few glaring issues which would need to be addressed. The biggest of which is a complicated administration interface and file handling on updates.

Products of the analysis were establishment of requirements and creation of several UML models. Those then aided in implementation by clearly establishing various actors, uses, tracking needed class and data structures and data flows.

The next step was a selection of frameworks. This decision was made due to the positives of using framework instead of pure PHP, mainly security features combined with quickening of development. Several frameworks were looked at and compared.

The implementation itself was done in parts. Each part consisted of a logically encapsulated block of functionality, beginning with database models, chaining to user's pages and finally the administration area. The interface design was being done along with its relevant parts.

The very last step was self assessment of the finished application and its deployment. 

---

# ONLY NOTES BELOW

---

## Analysis and design

### Functional requirements

### Non-functional requirements

### Use case model

![Use case diagram](./use-case-diagram.png "Use case diagram")

### Data model

![ERD diagram](./erd-diagram.png "ERD diagram")

---

## Implementation

---

## Conclusion

---

## Literature

---

## Attached files
